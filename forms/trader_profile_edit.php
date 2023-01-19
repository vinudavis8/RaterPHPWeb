<?php include "../layout/header.php";
include_once(dirname(__DIR__) . "/models/tradesmen.php");
include_once(dirname(__DIR__) . "/models/category.php");
include_once(dirname(__DIR__) . "/models/location.php");
$user = new User();
$trader = new Tradesmen();
$location= new Location();
$user_id = $_SESSION['logged_in_user_id'];

$img_path = "";
$hourly_rate = 0;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $trader->user_id = $user_id;
    $trader->name = $_POST["name"];
    $trader->phone = $_POST["phone"];
    $trader->email = $_POST["email"];
    $trader->location = $_POST["location"];
    $trader->category = $_POST["category"];
    $trader->password = $_POST["password"];
    if ($_POST["rate"] != "") {
        $hourly_rate = $_POST["rate"];
    }
    $trader->hourly_rate =  $hourly_rate;
    $trader->description = $_POST["description"];
    $trader->professional_certification = $_POST["certification"];
    $trader->skills = $_POST['skills'];
    $img_path = $_POST["profile_image_path"];
    $file_name = $_FILES['fileToUpload']['name'];
    if ($file_name != "") {
        $file_tmp = $_FILES['fileToUpload']['tmp_name'];
        $uploads_dir = dirname(__DIR__) . '/images/profile/' . $file_name;
        move_uploaded_file($file_tmp, $uploads_dir);
        $img_path = $file_name;
    }

    $trader->profile_image = $img_path;
    $rowcount = $trader->updateTradesmen($trader);
    $message = "";
    if ($rowcount === 1) {
        echo "<div class='alert alert-success text-center alert-dismissible'> 
        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
        <strong>Success..!</strong><span>  Profile details updated successfully</span></div>";
    } else
        echo "<div class='alert alert-danger text-center alert-dismissible'>
    <button type='button' class='btn-close' data-bs-dismiss='alert'></button> <strong>Failed..!</strong><span>Update failed</span></div>";

} else {
    $user_id = $_SESSION['logged_in_user_id'];
    $trader = new Tradesmen();
    $result = $trader->getProfileDetails($user_id);
    if (mysqli_num_rows($result) === 1) {

        $row = mysqli_fetch_assoc($result);
        $trader->name = $row['name'];
        $trader->phone = $row['phone'];
        $trader->email = $row['email'];
        $trader->category = $row['category_id'];
        $trader->location = $row['location_id'];
        $trader->password = $row['password'];
        $trader->description = $row['description'];
        $trader->skills = $row['skills'];
        $trader->professional_certification = $row['professional_certification'];

        $img_path = $row["profile_image_path"];
        if ($img_path == "") {
            $img_path = "img_avatar.png";
        }
        if ($row["hourly_rate"] != "") {
            $hourly_rate =  $row['hourly_rate'];
        }
        $trader->hourly_rate = $hourly_rate;
    }
}

?>

<div class="container row mt-3">
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <div class='rounded shadow-box'>
            <?php echo " <img src=\"../images/profile/{$img_path}\" alt=\"Logo\"   class=\"rounded-pill profile-avatar\"> "; ?>
            <form action="trader_profile_edit.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="profile_image_path" id="profile_image_path" value="<?php echo $img_path ?>">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3 mt-3">
                            <label for="email">Name</label>
                            <?php echo "<input type=\"name\" class=\"form-control\" id=\"name\" placeholder=\"Enter name\" name=\"name\" value=\"{$trader->name}\">"; ?>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="email">Phone</label>
                            <?php echo "<input type=\"phone\" class=\"form-control\" id=\"phone\" placeholder=\"Enter phone\" name=\"phone\" value=\"{$trader->phone}\">"; ?>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="email">Email</label>
                            <?php echo "<input type=\"email\" class=\"form-control\" id=\"email\" placeholder=\"Enter email\" name=\"email\" value=\"{$trader->email}\">"; ?>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="email">Hourly Rate</label>
                            <?php echo "<input type=\"number\" class=\"form-control\" id=\"rate\" placeholder=\"Enter rate\" name=\"rate\" value=\"{$trader->hourly_rate}\">"; ?>
                        </div>

                        <div class="mb-3 mt-3 select-tradesmen">
                            <label for="email">Location</label>
                            <select class="form-select" id="location" name="location">
                                <?php
                                $result = $location->getLocationList();
                                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                    if ($trader->location == $row["location_id"])
                                        echo "   <option value='" . $row["location_id"] . "' selected='selected'>" . $row["location_name"] . "</option>";
                                    else
                                        echo "   <option value='" . $row["location_id"] . "'>" . $row["location_name"] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3 mt-3 select-tradesmen">
                            <label for="password">Professional Certification</label>
                            <?php echo "<input type=\"text\" class=\"form-control\" id=\"certification\" placeholder=\"Enter certification\" name=\"certification\" value=\"{$trader->professional_certification}\">"; ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3 mt-3">
                            <label for="email">User Type</label>
                            <select class="form-select" name="userType" id="userType" onchange="userTypeChange()">
                                <option value="tradesmen">Tradesmen</option>
                            </select>
                        </div>
                        <div class="mb-3 select-tradesmen">
                            <label for="pwd">Category</label>
                            <select class="form-select" id="category" name="category">
                                <?php
                                $category = new Category();
                                $result = $category->getCategoryList();
                                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                    if ($trader->category == $row["category_id"])
                                        echo "   <option value='" . $row["category_id"] . "' selected='selected'>" . $row["category_name"] . "</option>";
                                    else
                                        echo "   <option value='" . $row["category_id"] . "'>" . $row["category_name"] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="password">Password</label>
                            <?php echo " <input type=\"password\" class=\"form-control\" id=\"password\" placeholder=\"Enter password\" name=\"password\" value=\"{$trader->password}\">"; ?>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="description">Skills</label>
                            <?php echo " <textarea id=\"skills\"  class=\"form-control\" name=\"skills\" rows=\"2\" cols=\"50\" >{$trader->skills}</textarea>"; ?>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="description">Description</label>
                            <?php echo " <textarea id=\"description\"  class=\"form-control\" name=\"description\" rows=\"4\" cols=\"50\" >{$trader->description}</textarea>"; ?>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="description">Images</label>
                            <input name="fileToUpload" id="fileToUpload" type="file" multiple="multiple" />
                        </div>
                    </div>
                </div>
                <div class="row"><button type="submit" class="btn btn-success col-md-4 mb-3 center">Update </button></div>
            </form>
        </div>
    </div>
    <div class="col-md-3"></div>
</div>

<?php include "../layout/footer.php" ?>
<script>
    <?php include "../scripts/script.js" ?>
</script>