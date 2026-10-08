# InfinityFree automatic deployment

Status: prepared, not activated or tested against the hosting account.

The workflow installs production Composer dependencies and checks PHP syntax on pull requests and pushes to main. Uploads run only on main when the Actions variable INFINITYFREE_DEPLOY_ENABLED is exactly true.

## Confirmed application layout

The user-provided hosting screenshot shows nepalstay.bibeklamsal.tech/htdocs/ containing App/, Public/, Views/, JS/, vendor/, .env, .htaccess, and Composer files. The root index.php is an accidental test file, not the application entry point.

The root .htaccess now matches the working configuration supplied by the user: requests route to Public/index.php and Assets requests map to Public/Assets. Public/index.php loads vendor/ and .env from the application root.

The workflow uploads the repository intact to the application root and generates vendor/ from composer.lock. Confirm the FTP-relative destination from the FTP account before enabling; the file manager path suggests nepalstay.bibeklamsal.tech/htdocs/ but FTP path visibility can differ.

Confirm any other hosting-only application edits are incorporated into GitHub, since tracked files are overwritten. Back up current application files before the first upload.

## Configure GitHub

Open Settings > Secrets and variables > Actions.

Repository secrets:
- FTP_SERVER: FTP hostname shown by the NepalStay hosting account.
- FTP_USERNAME: FTP username for that account.
- FTP_PASSWORD: FTP password; enter directly into GitHub.
- FTP_SERVER_DIR: confirmed application root path relative to FTP, ending with /.

Repository variables:
- DEPLOY_PHP_VERSION: match the hosting PHP major.minor version; the workflow defaults to 8.3.
- INFINITYFREE_DEPLOY_ENABLED: leave unset until configuration is ready, then set to true.

The workflow uses explicit FTPS on port 21 with certificate verification. Confirm account support and diagnose failures without disabling verification.

## Activate and verify

After merging into main:
1. Add secrets and the PHP version variable.
2. Confirm the existing production .env remains in the application root.
3. Set INFINITYFREE_DEPLOY_ENABLED to true.
4. Open Actions > Deploy NepalStay to InfinityFree > Run workflow on main.
5. Check build/upload logs and test the homepage, assets, login, and bookings.

Later pushes to main upload automatically after build checks pass. Set the enable variable to false to pause uploads.

## Boundaries

- Production .env, SQL files, logs, editor metadata, docs, and Public/Assets/Uploads/ are excluded.
- Uploaded files and their existing .htaccess remain managed on the server.
- No database contents or schema are deployed.
- Composer scripts and plugins are disabled during installation.
- Keep .ftp-deploy-sync-state.json on the server for incremental uploads.
- Previously deployed tracked files may be removed when removed from GitHub; unrelated server files are not cleaned.
- FTP uploads are not atomic. Investigate failed uploads and rerun; rollback requires deploying a known good version.
