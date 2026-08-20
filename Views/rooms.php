<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>NepalStay</title>

    <link rel="stylesheet" href="/Assets/CSS/style.css">

    <script src="/Nepalstay/Public/Assets/JS/main.js" defer></script>

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
    />
</head>
<div class="rooms">

    <?php foreach ($rooms as $room): ?>

        <a href="/room?room_id=<?= (int) $room['id'] ?>">

            <div class="room">
               

                <?php if (!empty($room['main_image'])): ?>
                    <img
                        src="<?= htmlspecialchars($room['main_image']) ?>"
                        alt="<?= htmlspecialchars($room['title']) ?>"
                    >
                <?php endif; ?>

                <div class="contents">

                    <div class="number">
                        <?= htmlspecialchars((string) $room['capacity']) ?> GUESTS
                    </div>

                    <h1>
                        <?= htmlspecialchars($room['title']) ?>
                    </h1>

                    <p>
                        <?= htmlspecialchars($room['description']) ?>
                    </p>

                    <div class="price-row">

                        <div class="price">
                            <h1>
                                NPR <?= htmlspecialchars((string) $room['price']) ?>
                            </h1>
                            <h3>/night</h3>
                        </div>

                        <div class="view-details">
                            VIEW DETAILS
                        </div>

                    </div>

                </div>

            </div>

        </a>

    <?php endforeach; ?>

</div>