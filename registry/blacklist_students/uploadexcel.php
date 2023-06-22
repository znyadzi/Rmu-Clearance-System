<?php  
session_start();
if (!isset($_SESSION['user_name']))
{
    header("Location:/rmuclearance/registry_login/");
    die();
}
include("datacon.php");
$username=$_SESSION['user_name'];
$sql="SELECT user_department FROM departmental_logs WHERE username='$username'";
$result=mysqli_query($conn, $sql);
$row=mysqli_fetch_array($result);
$department=$row['user_department'];

if(isset($_POST['submit'])) {
     if(isset($_FILES['uploadFile']['name']) && $_FILES['uploadFile']['name'] != "") {
        $allowedExtensions = array("xls","xlsx");
        $ext = pathinfo($_FILES['uploadFile']['name'], PATHINFO_EXTENSION);
		
        if(in_array($ext, $allowedExtensions)) {
				// Uploaded file
               $file = "uploads/".$_FILES['uploadFile']['name'];
               $isUploaded = copy($_FILES['uploadFile']['tmp_name'], $file);
			   // check uploaded file
               if($isUploaded) {
					// Include PHPExcel files and database configuration file
					require_once __DIR__ . '/vendor/autoload.php';
                    include(__DIR__ .'/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php');
                    try {
                        // load uploaded file
                        $objPHPExcel = PHPExcel_IOFactory::load($file);
                    } catch (Exception $e) {
                         die('Error loading file "' . pathinfo($file, PATHINFO_BASENAME). '": ' . $e->getMessage());
                    }
                    
                    // Specify the excel sheet index
                    $sheet = $objPHPExcel->getSheet(0);
                    $total_rows = $sheet->getHighestRow();
					$highestColumn      = $sheet->getHighestColumn();	
					$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);		
					
					//	loop over the rows
					for ($row = 1; $row <= $total_rows; ++ $row) {
						for ($col = 0; $col < $highestColumnIndex; ++ $col) {
							$cell = $sheet->getCellByColumnAndRow($col, $row);
							$val = $cell->getValue();
							$records[$row][$col] = $val;
						}
					}
					foreach($records as $row){
						// HTML content to render on webpage
						$index_number = isset($row[0]) ? $row[0] : '';
						$reason = isset($row[1]) ? $row[1] : '';
                        //Check for duplication
                        $query="SELECT * FROM blacklisted_students WHERE action_by='$username' AND index_number='$index_number'";
                        $result=mysqli_query($conn, $query);
                        $result_check=mysqli_num_rows($result);
                        if($result_check > 0)
                        {
                            echo "<script> alert('Duplicate entry found:$index_number'); window.location='index.php'; </script> ";  
                            exit();
                        }
                        else
                        {
                            // Insert into database
                            $query = "INSERT INTO blacklisted_students (index_number, reason, action_by, department) 
                                    values('".$index_number."', '".$reason."', '".$username."', '".$department."')";
                            $result=mysqli_query($conn, $query);
                            if(!$result)
                            {
                                echo "Not Inserted";
                                echo "Errormessage:".mysqli_error($conn);
                                
                            }
                            echo "<script> alert('Upload of Document Successful'); window.location='index.php'; </script> "; 

                        }
					}
				
                    unlink($file);
                } else {
                    echo '<span class="msg">File not uploaded!</span>';
                }
        } else {
            echo '<span class="msg">Please upload excel sheet.</span>';
        }
    } else {
        echo '<span class="msg">Please upload excel file.</span>';
    }
}
?>