<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <div class="modal fade" id="equipmentModal11" tabindex="-1" role="dialog" aria-labelledby="equipmentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="equipmentModalLabel">Add Equipment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="../db/Add_Product.php" method="POST" enctype="multipart/form-data" id='dateForm'>
                        <div class="form-group">
                            <label for="equipmentType">Equipment Type:</label>
                            <input type="text" class="form-control" name="equipmentType" id="equipmentType" required>
                        </div>

                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea class="form-control" name="description" id="description" rows="4"
                                required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="rentalCostPerHour">Rental Cost (per hour):</label>
                            <input type="number" class="form-control" name="rentalCostPerHour" id="rentalCostPerHour"
                                required>
                        </div>

                        <div class="form-group">
                            <label for="rentalCostPerDay">Rental Cost (per day):</label>
                            <input type="number" class="form-control" name="rentalCostPerDay" id="rentalCostPerDay"
                                required>
                        </div>

                        <div class="form-group">
                            <label for="fromDate">Availability From:</label>
                            <input type="date" class="form-control" name="fromDate" id="fromDate" required>
                        </div>

                        <div class="form-group">
                            <label for="toDate">Availability To:</label>
                            <input type="date" class="form-control" name="toDate" id="toDate" required>
                        </div>

                        <div class="form-group">
                            <label for="image">Upload Image:</label>
                            <input type="file" class="form-control" name="image" id="image" accept="image/*" required>
                        </div>

                        <input type="hidden" name="ownerID" value="<?php echo $ownerID; ?>">

                        <button type="submit" class="btn btn-success">Submit</button>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
    const dateForm = document.getElementById('dateForm');
    const fromDateInput = document.getElementById('fromDate');
    const toDateInput = document.getElementById('toDate');

    dateForm.addEventListener('submit', function(e) {
        const fromDate = new Date(fromDateInput.value);
        const toDate = new Date(toDateInput.value);

        if (fromDate >= toDate) {
            alert('To date must be greater than from date');
            e.preventDefault(); // Prevent form submission
        }
    });
    </script>
</body>

</html>