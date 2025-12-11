<?php
$data = json_decode(file_get_contents("data.json"), true);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Recipe Manager</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<header>
    <h1>Recipe Manager</h1>
    <nav>
        <a href="#add">Add Recipe</a>
        <a href="#recipes">Recipes</a>
        <a href="#planner">Meal Plan</a>
    </nav>
</header>

<div class="container">

<!-- ADD FORM -->
<section id="add">
    <h2>Add Recipe</h2>

    <form action="logic.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="action" value="add">

        <label>Recipe Title:</label>
        <input type="text" name="title" required>

        <label>Ingredients:</label>
        <textarea name="ingredients" required></textarea>

        <label>Image:</label>
        <input type="file" name="image" accept="image/*" required>

        <button type="submit">Add Recipe</button>
    </form>
</section>

<hr>

<!-- RECIPE GRID -->
<section id="recipes">
    <h2>All Recipes</h2>

    <div class="recipe-grid">
        <?php foreach ($data["recipes"] as $r): ?>
            <div class="recipe-card">
                <img src="uploads/<?= $r['image'] ?>">
                <h3><?= htmlspecialchars($r["title"]) ?></h3>
                <p><?= nl2br(htmlspecialchars($r["ingredients"])) ?></p>

                <form method="POST" action="logic.php">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?= $r['id'] ?>">
                    <button class="delete-btn">Delete</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>

</section>

<hr>

<!-- WEEKLY PLANNER -->
<section id="planner">
    <h2>Weekly Meal Planner</h2>

    <form action="logic.php" method="POST">
        <input type="hidden" name="action" value="save_plan">

        <?php foreach ($data["mealplan"] as $day => $value): ?>
            <label><strong><?= ucfirst($day) ?></strong></label>
            <select name="<?= $day ?>">
                <option value="">-- Choose Recipe --</option>

                <?php foreach ($data["recipes"] as $r): ?>
                    <option <?= ($value == $r["title"]) ? "selected" : "" ?>>
                        <?= $r["title"] ?>
                    </option>
                <?php endforeach; ?>
            </select><br><br>
        <?php endforeach; ?>

        <button>Save Weekly Plan</button>
    </form>

    <h3>Current Plan</h3>
    <ul>
        <?php foreach ($data["mealplan"] as $day => $value): ?>
            <li><strong><?= ucfirst($day) ?>:</strong> <?= $value ?: "None" ?></li>
        <?php endforeach; ?>
    </ul>
</section>

</div>
</body>
</html>
