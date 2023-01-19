<?php 
include "../layout/header.php";
include_once(dirname(__DIR__) . "/models/category.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST["name"];
    $category = new Category();
    $rowcount = $category->createCategory($name);
    $message = "";
    if ($rowcount === 1) {
        $message = "Category created successfully";
    } else
        $message = "Category creation failed";
    echo "<div class='alert alert-success text-center'> <strong><span>" . $message . "</span></strong></div>";
}
?>
<div class="container  mt-3 grid-div">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class='rounded shadow-box'>
                <h2 class="text-center">Create category</h2>
                <form action="create_category.php" method="POST">
                    <div class="mb-3 mt-3">
                        <label for="email">Category Name</label>
                        <input type="name" class="form-control" id="name" placeholder="Enter name" name="name" required>
                    </div>
                    <div class="row  justify-content-center mb-3">
                        <button type="submit" class="btn btn-success col-md-3">Add Category</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>
<?php include "../layout/footer.php" ?>
<script>
    <?php include "../scripts/script.js" ?>
</script>