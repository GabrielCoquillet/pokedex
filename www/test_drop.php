<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multi-Select Dropdown</title>
    <style>
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            padding: 10px;
            z-index: 1;
        }

        .dropdown-content input {
            margin-right: 5px;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown-content label {
            display: block;
            margin: 5px 0;
        }
    </style>
</head>
<body>
<form method="POST" action="process.php">
    <div class="dropdown">
        <button type="button">None selected</button>
        <div class="dropdown-content">
            <label><input type="checkbox" name="ingredients[]" value="Cheese"> Cheese</label>
            <label><input type="checkbox" name="ingredients[]" value="Tomatoes"> Tomatoes</label>
            <label><input type="checkbox" name="ingredients[]" value="Mozzarella"> Mozzarella</label>
            <label><input type="checkbox" name="ingredients[]" value="Mushrooms"> Mushrooms</label>
            <label><input type="checkbox" name="ingredients[]" value="Pepperoni"> Pepperoni</label>
            <label><input type="checkbox" name="ingredients[]" value="Onions"> Onions</label>
        </div>
    </div>
    <br>
    <button type="submit">Submit</button>
</form>

<?php
// Example for processing the data on form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['ingredients'])) {
        echo "You selected: " . implode(', ', $_POST['ingredients']);
    } else {
        echo "No ingredients selected.";
    }
}
?>
</body>
</html>

