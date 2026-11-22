<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  
<table>
  <thead>
    <tr>
      <th>Name</th>
      <th>number</th>
      <th>Email Address</th>
      <th>Phone Number</th>
      <th>Status</th>
      <th>Balance</th>
      <th>Password</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Row 1, Col 1</td>
      <td>Row 1, Col 2</td>
      <td>Row 1, Col 3</td>
      <td>Row 1, Col 4</td>
      <td>Row 1, Col 5</td>
      <td>Row 1, Col 6</td>
      <td>Row 1, Col 7</td>
    </tr>
  </tbody>
</table>
<?php


function generateTenDigitNumber(): int {
    return random_int(1000000000, 9999999999);
}

// Example usage:
echo generateTenDigitNumber() . "\n"; // e.g., 4829104821

?>
</body>
</html>
