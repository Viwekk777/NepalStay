<?php
declare(strict_types=1);
spl_autoload_register(function(string $class):void{$p=__DIR__.'/../'.str_replace('\\','/',$class).'.php';if(is_file($p))require $p;});
set_error_handler(function($severity,$message,$file,$line){throw new ErrorException($message,0,$severity,$file,$line);});
function check(bool $ok,string $msg):void{if(!$ok)throw new RuntimeException($msg);}
function capture(callable $fn):string{ob_start();try{$fn();return ob_get_contents();}finally{ob_end_clean();}}
class ResetTestMailer extends \App\Services\Mailer {
    public array $sent=[]; public array $notifications=[];
    public function sendPasswordReset(string $email,string $url):void{$this->sent[]=[$email,$url];}
    public function sendPasswordChanged(string $email):void{$this->notifications[]=$email;}
}
$db=new PDO('sqlite::memory:');$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
$db->exec('CREATE TABLE users (id INTEGER PRIMARY KEY,email TEXT,password_hash TEXT)');
$stmt=$db->prepare('INSERT INTO users VALUES (1,:email,:password)');
$stmt->execute(['email'=>'guest@example.test','password'=>password_hash('Original1!',PASSWORD_DEFAULT)]);
$model=new \App\Models\PasswordReset($db);$mail=new ResetTestMailer();
$controller=new \App\Controllers\PasswordResetController($model,$mail);
$_SESSION=[];$_POST=[];$_GET=[];$_SERVER['REQUEST_METHOD']='GET';
check(str_contains(capture(fn()=>$controller->forgot()),'Send reset link'),'Forgot form renders');
$csrf=$_SESSION['reset_csrf'];$_SERVER['REQUEST_METHOD']='POST';
$_POST=['email'=>'guest@example.test','csrf'=>'wrong'];capture(fn()=>$controller->forgot());
check(http_response_code()===403 && !$mail->sent,'CSRF blocks email requests');
$_POST=['email'=>[],'csrf'=>$csrf];capture(fn()=>$controller->forgot());check(http_response_code()===422,'Malformed input rejected');
$_POST=['email'=>'guest@example.test','csrf'=>$csrf];$known=capture(fn()=>$controller->forgot());
check(count($mail->sent)===1,'Known email receives link');parse_str(parse_url($mail->sent[0][1],PHP_URL_QUERY),$query);$token=$query['token'];
check(strlen($token)===64 && $model->valid($token),'Generated token works');
check($db->query('SELECT token_hash FROM password_resets')->fetchColumn()!==$token,'Only token hash stored');
check($model->issue('guest@example.test')===null,'Per-account cooldown works');
check(password_verify('Original1!',$db->query('SELECT password_hash FROM users')->fetchColumn()),'Request leaves password unchanged');
$_SESSION['reset_last_request']=0;$_POST['email']='missing@example.test';$unknown=capture(fn()=>$controller->forgot());
check($known===$unknown && count($mail->sent)===1,'Same public output for unknown accounts');
$_GET=['token'=>$token];$_POST=[];$_SERVER['REQUEST_METHOD']='GET';
check(str_contains(capture(fn()=>$controller->reset()),'Choose a new password') && $model->valid($token),'GET never consumes token');
$_SERVER['REQUEST_METHOD']='POST';$_POST=['token'=>$token,'csrf'=>$csrf,'password'=>'weak','password_confirmation'=>'weak'];
capture(fn()=>$controller->reset());check(http_response_code()===422 && $model->valid($token),'Weak password rejected');
$_POST['password']='NewPassword2!';$_POST['password_confirmation']='different';capture(fn()=>$controller->reset());check(http_response_code()===422,'Confirmation must match');
$_POST['password_confirmation']='NewPassword2!';$_POST['csrf']='wrong';capture(fn()=>$controller->reset());check(http_response_code()===403,'Reset requires CSRF');
$_POST['csrf']=$csrf;$html=capture(fn()=>$controller->reset());
check(str_contains($html,'Your password has been updated'),'Valid reset completes');
check(password_verify('NewPassword2!',$db->query('SELECT password_hash FROM users')->fetchColumn()),'New hash saved');
check(!$model->valid($token) && $model->consume($token,'Another3!')===null,'Token replay blocked');
check(count($mail->notifications)===1 && !isset($_SESSION['user_id']),'Notify user and require login');
$db->exec('UPDATE password_resets SET requested_at=0');$token=$model->issue('guest@example.test');
$db->exec('UPDATE password_resets SET expires_at=0');check(!$model->valid($token) && $model->consume($token,'Another3!')===null,'Expiry enforced');
$db->exec('UPDATE password_resets SET requested_at=0');$older=$model->issue('guest@example.test');
$db->exec('UPDATE password_resets SET requested_at=0');$newer=$model->issue('guest@example.test');
check(!$model->valid($older) && $model->valid($newer),'Resend replaces old token');
$db->exec("UPDATE users SET email='changed@example.test'");check(!$model->valid($newer),'Email changes invalidate links');
$db->exec('UPDATE password_resets SET requested_at=0, request_count=5');check($model->issue('changed@example.test')===null,'Hourly limit works');
check(!$model->valid('invalid'),'Malformed tokens rejected');
echo "Password reset regression checks passed.\n";
