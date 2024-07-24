<?php

include 'PanelGenel.php';

if(empty($_POST["call"]))
{
    echo "*error* Yükleme fonksiyonu alınamadı!";
    return;
}
$callFunction = $_POST["call"];

if($callFunction == "GetListManager"){
    GetListManager($conn);
    mysqli_close($conn);
    return;
}

if($callFunction == "AddList"){
    AddList($conn);
    mysqli_close($conn);
    return;
}

if($callFunction == "DeleteList"){
    DeleteList($conn);
    mysqli_close($conn);
    return;
}

if($callFunction == "LoadList"){
    LoadList($conn);
    mysqli_close($conn);
    return;
}

if($callFunction == "AddListElement"){
    AddListElement($conn);
    mysqli_close($conn);
    return;
}

if($callFunction == "DeleteListelement"){
    DeleteListelement($conn);
    mysqli_close($conn);
    return;
}

if($callFunction == "ListUpdate"){
    ListUpdate($conn);
    mysqli_close($conn);
    return;
}
if($callFunction == "ListElementsUpdate"){
    ListElementsUpdate($conn);
    mysqli_close($conn);
    return;
}




echo "*error* Yükleme fonksiyonu bulunamadı!";
return;
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




function GetListManager($conn){

	$sql = "SELECT * FROM lists";
	$Result = mysqli_query($conn,$sql);

	if($Result==NULL||mysqli_num_rows($Result)==0)
	{
		echo "<p>Liste bulunamadı!</p>";
	}

	echo "<div  style=\"border:dotted; padding:1em;\">";

	echo "<select id=\"selLists\" onchange=\"LoadList(this.value,1);\">";

	echo "<option></option>";


	while($Row = mysqli_fetch_assoc($Result))
	{
		echo "<option value=\"".$Row["id"]."\">".$Row["name"]."</option>";
	}

	echo "</select> <input type=\"button\" value=\"Sil\" onclick=\"DeleteList();\" /> <br /><br />";

	echo "<input id=\"txtListeAdi\" type=\"text\" placeholder=\"Yeni Liste\" /> <input type=\"button\" value=\"Liste Ekle\" onclick=\"AddList();\" />";
	echo "</div>";
	echo "<div id=\"divLists\" style=\"border:dotted; padding:1em;\">";
	echo "</div>";


}

function AddList($conn){

	$sqlInsert = "INSERT INTO lists (name) VALUES ('".$_POST["listName"]."')";

	if(mysqli_query($conn,$sqlInsert))
	{
		echo "ok";
	}
	else
	{
		echo "*error* Liste eklenirken hata oluştu!";
	}

}

function DeleteList($conn){


	$sqlDeleteElements = "DELETE FROM tagelements WHERE type='listitem' AND parentid=".$_POST["listid"];

	if(mysqli_query($conn,$sqlDeleteElements))
	{

	}
	else
	{
		echo "*error* tagelements silinirken hata oluştu!";
		return;

	}




	$sqlDeleteGroup = "DELETE FROM lists WHERE id=".$_POST["listid"];

	if(mysqli_query($conn,$sqlDeleteGroup))
	{
		echo "ok";
	}
	else
	{
		echo "*error* liste silinirken hata oluştu!";
		return;
	}


}

function LoadList($connection){

    $listid = $_POST["listid"];
    $langid = $_POST["langid"];

	$sqlSelect ="SELECT * FROM lists WHERE id=".$listid;
	$Result = mysqli_query($connection,$sqlSelect);

	if($Result == NULL||mysqli_num_rows($Result) == 0)
	{
		echo "<p>Eleman bulunamadı</p>";
		return;
	}

	$listRow = mysqli_fetch_assoc($Result);

	echo "<h1>".$listRow["name"]."</h1>";
	echo "<label>tag:</label><input id=\"".$listRow["id"]."_listtag\" type=\"text\" value=\"".$listRow["tag"]."\" />";

	if(isset($_SESSION["admin"]))
	echo "<label>parametre:</label><input id=\"".$listRow["id"]."_listparam\" type=\"text\" value=\"".htmlspecialchars($listRow["parameter"])."\" style=\"width:100%;\" />";

	echo getLanguageSelectList($listid,$langid,$connection);
	echo "<div style=\"border:dotted;margin-top:2em; padding:1em;\">";

	$sqlElements ="SELECT * FROM tagelements WHERE type = 'listitem' AND langid IN(0,".$langid.") AND parentid=".$listid. " ORDER BY sira";
	$elementsResult = mysqli_query($connection,$sqlElements);

	if($elementsResult == NULL||mysqli_num_rows($elementsResult) == 0)
	{
		echo "<p>Eleman bulunamadı</p>";

	}

	while($elementRow = mysqli_fetch_assoc($elementsResult))
	{
		echo "<div style=\"display:block;\">";

		if(isset($_SESSION["admin"]))
		echo "<label>parametre:</label><input type=\"text\" id=\"".$elementRow["id"]."_elementparam\" value=\"".htmlspecialchars($elementRow["parameter"])."\" style=\"width:100%;\" />";

		echo "<label>isim:</label><input type=\"text\" id=\"".$elementRow["id"]."_elementname\" value=\"".$elementRow["name"]."\" />";
		echo "<label>değer:</label><input type=\"text\" id=\"".$elementRow["id"]."_elementvalue\" value=\"".htmlspecialchars($elementRow["value"])."\" />";
		echo "<input type=\"button\" value=\"SİL\" onclick=\"DeleteListElement(".$listid.",".$elementRow["id"].");\" />";

		echo "</div>";

	}


	echo "</div>";
	echo "<input type=\"button\" value=\"KAYDET\" onclick=\"ListElementsUpdate(".$listid.");\" />";
	echo "<input type=\"button\" value=\"EKLE\" onclick=\"AddListElement(".$listRow["id"].");\" />";



}

function getLanguageSelectList($listid,$langid,$connection){

	$sqlSelect ="SELECT * FROM lang";
	$selectResult = mysqli_query($connection,$sqlSelect);

	if($selectResult == NULL||mysqli_num_rows($selectResult) ==0)
	{
		return;
	}

	$selectString = "<select id=\"list_langselect\" onchange=\"LoadList(".$listid.",this.value);\">";

	while($selectRow = mysqli_fetch_assoc($selectResult))
	{
		if(empty($langid) || $langid != $selectRow["id"])
			$selectString .="<option value=\"".$selectRow["id"] ."\">". $selectRow["name"] ."</option>";
		else
			$selectString .="<option value=\"".$selectRow["id"] ."\" selected=\"selected\">". $selectRow["name"] ."</option>";

	}

	$selectString .= "</select>";

	return $selectString;

}

function AddListElement($conn){

	$sqlLang ="SELECT id FROM lang";
	$langResult = mysqli_query($conn,$sqlLang);

	if($langResult==NULL||mysqli_num_rows($langResult)==0)
	{
		echo "<p>Kayıtlı dil bulunamadı!</p>";
		return;
	}



	for ($langArr = array (); $langRow = mysqli_fetch_assoc($langResult); $langArr[] = $langRow);


	//mysqli_data_seek($result, 399);

	$elementOrder=1;



	for($j=0; $j<count($langArr); $j++)
	{

		$sqlInsert = "INSERT INTO tagelements (langid,parentid,type,sira) VALUES (".$langArr[$j]["id"].", ".$_POST["listid"].", 'listitem', ".$elementOrder.")";

		if(mysqli_query($conn,$sqlInsert))
		{
			$elementOrder++;
		}
		else
		{
			echo "*error* Liste elemanı eklenirken hata oluştu!";
			return;
		}

	}

		echo "ok";

}

function DeleteListElement($conn){

    $sqlDeleteElements = "DELETE FROM tagelements WHERE id=".$_POST["itemid"];

    if(mysqli_query($conn,$sqlDeleteElements))
    {

    }
    else
    {
        echo "*error* eleman silinirken hata oluştu!";
        return;

    }

    echo "ok";

}

function ListUpdate($conn){

    $listid = $_POST["listid"];
    $tagvalue = $_POST["tagvalue"];
    $parameter = $_POST["parameter"];

	$sqlOrder ="UPDATE lists SET tag='".$tagvalue."', parameter='".$parameter."' WHERE id=". $listid;

	if(!mysqli_query($conn,$sqlOrder))
	{
		echo "*error* Liste güncellenirken hata oluştu!";
		return;
	}

	echo "ok";

}

function ListElementsUpdate($conn){

    $elementid = $_POST["elementid"];
    $valueField = $_POST["valueField"];
    $value = $_POST["value"];


	if($valueField=="elementparam")
	{
		$valueField="parameter";
	}
	else if($valueField=="elementname")
	{
		$valueField="name";
	}
	else if($valueField=="elementvalue")
	{
		$valueField="value";
	}
	else
	{
		echo "ok";
		return;
	}

	$value = str_replace("'","''" , $value );


	$sqlUpdate="UPDATE tagelements SET ".$valueField."='".$value."' WHERE id=".$elementid;


	if(!mysqli_query($conn,$sqlUpdate))
	{
		echo "*error* Liste güncellenirken hata oluştu!";
		return;
	}

	echo "ok";



}

