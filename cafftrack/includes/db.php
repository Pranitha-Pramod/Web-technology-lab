<?php
$conn = mysqli_connect("sql104.infinityfree.com", "if0_41653146", "MyCalc2026", "if0_41653146_cafftrack");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>