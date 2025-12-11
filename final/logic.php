<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$file = "data.json";

if (!file_exists($file)) {
    $empty = [
        "recipes" => [],
        "mealplan" => [
            "monday" => "",
            "tuesday" => "",
            "wednesday" => "",
            "thursday" => "",
            "friday" => "",
            "saturday" => "",
            "sunday" => ""
        ]
    ];
    file_put_contents($file, json_encode($empty, JSON_PRETTY_PRINT));
}

$data = json_decode(file_get_contents($file), true);


/* =============== ADD RECIPE =============== */
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"]) && $_POST["action"] === "add") {

    $imageName = time() . "_" . $_FILES["image"]["name"];
    move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/" . $imageName);

    $data["recipes"][] = [
        "id" => time(),
        "title" => $_POST["title"],
        "ingredients" => $_POST["ingredients"],
        "image" => $imageName
    ];

    file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
    header("Location: index.php");
    exit;
}

/* =============== DELETE RECIPE =============== */
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"]) && $_POST["action"] === "delete") {
    $id = $_POST["id"];
    foreach ($data["recipes"] as $i => $r) {
        if ($r["id"] == $id) {
            if (file_exists("uploads/" . $r["image"])) unlink("uploads/" . $r["image"]);
            unset($data["recipes"][$i]);
        }
    }
    $data["recipes"] = array_values($data["recipes"]);
    file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
    header("Location: index.php");
    exit;
}

/* =============== SAVE MEAL PLAN =============== */
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"]) && $_POST["action"] === "save_plan") {
    foreach ($data["mealplan"] as $day => $v) {
        $data["mealplan"][$day] = $_POST[$day];
    }
    file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Recipe Manager</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <nav>
        <a href="#add">Add Recipe</a>
        <a href="#recipes">Recipes</a>
        <a href="#planner">Meal Planner</a>
    </nav>
</header>

<div class="container">
    <h1>Recipe Manager</h1>

    <!-- ADD RECIPE -->
    <section id="add">
        <h2>Add Recipe</h2>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="add">
            <label>Recipe Name:</label>
            <input type="text" name="title" required>
            <label>Ingredients (one per line):</label>
            <textarea name="ingredients" required></textarea>
            <label>Upload Real Food Image:</label>
            <input type="file" name="image" accept="image/*" required>
            <input type="submit" value="Add Recipe">
        </form>
    </section>

    <hr>

    <!-- RECIPES LIST -->
    <section id="recipes">
        <h2>All Recipes</h2>
        <?php if (count($data["recipes"]) === 0): ?>
            <p>No recipes yet.</p>
        <?php else: ?>
            <?php foreach ($data["recipes"] as $r): ?>
                <div class="card">
                    <img src="uploads/<?php echo $r['image']; ?>" alt="<?php echo htmlspecialchars($r['title']); ?>">
                    <h3><?php echo htmlspecialchars($r['title']); ?></h3>
                    <p><?php echo nl2br(htmlspecialchars($r['ingredients'])); ?></p>
                    <form method="POST">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?php echo $r['id']; ?>">
                        <button class="delete-btn">Delete</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </section>

    <hr>

    <!-- MEAL PLANNER -->
    <section id="planner">
        <h2>Weekly Meal Planner</h2>
        <form method="POST">
            <input type="hidden" name="action" value="save_plan">
            <?php foreach ($data["mealplan"] as $day => $value): ?>
                <label><strong><?php echo ucfirst($day); ?></strong></label>
                <select name="<?php echo $day; ?>">
                    <option value="">-- Choose Recipe --</option>
                    <?php foreach ($data["recipes"] as $r): ?>
                        <option value="<?php echo htmlspecialchars($r['title']); ?>" <?php echo ($value === $r['title']) ? "selected" : ""; ?>>
                            <?php echo htmlspecialchars($r['title']); ?>
                        </option>
                    <?php endforeach; ?>
                </select><br><br>
            <?php endforeach; ?>
            <input type="submit" value="Save Weekly Plan">
        </form>

        <h3>Current Plan</h3>
        <ul>
            <?php foreach ($data["mealplan"] as $day => $value): ?>
                <li><strong><?php echo ucfirst($day); ?>:</strong> <?php echo $value ?: "None"; ?></li>
            <?php endforeach; ?>
        </ul>
    </section>

</div>
</body>
</html>
