<form action="http://localhost/MajdBenAbdallah/model/handle_request.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="action" value="add_sponsor">
    <div class="form-group">
        <label for="name">Sponsor Name</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="logo">Sponsor Logo</label>
        <input type="file" name="logo" class="form-control">
    </div>
    <div class="form-group">
        <label for="contact_info">Contact Info</label>
        <textarea name="contact_info" class="form-control"></textarea>
    </div>
    <button type="submit" class="btn btn-success">Add Sponsor</button>
</form>
