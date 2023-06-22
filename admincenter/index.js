function deleteRow(rowId) {
    if (confirm("Are you sure you want to delete this row?")) {
      // AJAX request to delete the row from the database
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "delete_row.php", true);
      xhr.send("rowId=" + rowId);
    }
  }