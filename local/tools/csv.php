<?
$row = 1;
$arRedirect = Array();
if (($handle = fopen($_SERVER["DOCUMENT_ROOT"]."/local/tools/redirect.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 10000, ";")) !== FALSE) {
        $num = count($data);
        $row++;
		$arRedirect[$data[0]] = $data[1];
    }
    fclose($handle);
}
$data = serialize($arRedirect);     
file_put_contents($_SERVER["DOCUMENT_ROOT"]."/local/tools/redirect.txt", $data);
?>

