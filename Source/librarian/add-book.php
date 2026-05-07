<?php 
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

include 'inc/header.php';
include 'inc/connection.php';

// Load genres from DB
$genres = mysqli_query($link, "SELECT * FROM genres ORDER BY genre_name ASC");
?>

<!-- dashboard area -->
<div class="dashboard-content">
    <div class="dashboard-header">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="left">
                        <p><span>dashboard</span>Control panel</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="right text-right">
                        <a href="dashboard.php"><i class="fas fa-home"></i>home</a>
                        <span class="disabled">add book</span>
                    </div>
                </div>
            </div>

            <div class="bstore">
                <form action="" method="post" enctype="multipart/form-data">
                    <table class="table table-bordered">

                        <tr>
                            <td>
                                <input type="text" class="form-control" name="booksname" placeholder="Book name" required>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <label>Book Image</label>
                                <input type="file" class="form-control" name="f1" required>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <label>Book File (PDF)</label>
                                <input type="file" class="form-control" name="file" required>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <input type="text" class="form-control" name="bauthorname" placeholder="Author name" required>
                            </td>
                        </tr>

                        <!-- GENRE DROPDOWN -->
                        <tr>
                            <td>
                                <label>Genre</label>
                                <select name="genre" class="form-control" required>
                                    <option value="">Select Genre</option>
                                    <?php while ($g = mysqli_fetch_assoc($genres)) : ?>
                                        <option value="<?= $g['genre_name']; ?>"><?= $g['genre_name']; ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <input type="text" class="form-control" name="bpubname" placeholder="Publication name" required>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <input type="text" class="form-control" name="bpurcdate" placeholder="Purchase date (e.g. 12/03/19)" required>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <input type="text" class="form-control" name="bprice" placeholder="Price" required>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <input type="text" class="form-control" name="bquantity" placeholder="Quantity" required>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <input type="text" class="form-control" name="bavailability" placeholder="Availability" required>
                            </td>
                        </tr>
                    </table>

                    <div class="submit mt-20">
                        <input type="submit" name="submit" class="btn btn-info submit" value="Add Book">
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<?php
// PROCESS FORM
if (isset($_POST["submit"])) {

    // Upload files
    $image_name = $_FILES['f1']['name'];
    $file_name = $_FILES['file']['name'];

    $temp = explode(".", $image_name);
    $temp2 = explode(".", $file_name);

    $newfilename = round(microtime(true)) . '.' . end($temp);
    $newfilename2 = round(microtime(true)) . '.' . end($temp2);

    $imagepath = "books-image/" . $newfilename;
    $filepath = "books-file/" . $newfilename2;

    move_uploaded_file($_FILES["f1"]["tmp_name"], $imagepath);
    move_uploaded_file($_FILES["file"]["tmp_name"], $filepath);

    // FIXED INSERT QUERY WITH GENRE + STATUS
    mysqli_query($link, "
        INSERT INTO add_book 
        (books_name, books_image, books_author_name, genre, books_publication_name, 
         books_purchase_date, books_price, books_quantity, books_availability, 
         librarian_username, books_file, status)
        VALUES (
            '$_POST[booksname]',
            '$imagepath',
            '$_POST[bauthorname]',
            '$_POST[genre]',
            '$_POST[bpubname]',
            '$_POST[bpurcdate]',
            '$_POST[bprice]',
            '$_POST[bquantity]',
            '$_POST[bavailability]',
            '$_SESSION[username]',
            '$filepath',
            'active'
        )
    ");

    echo "<script>alert('Book added successfully!'); window.location='display-books.php';</script>";
}
?>

<?php include 'inc/footer.php'; ?>
