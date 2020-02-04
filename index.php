<?php 

require("includes/DBconnect.php");

$page_title = 'Welcome to this Social Media Site!';
include('includes/header.html');
session_start();
echo "<br/><br/>";

echo '<div class="page-header"><h1>Most Recent Posts</h1></div>';

if (isset($_SESSION['name']))
{
	echo "Welcome, ".$_SESSION['name']."<br/>";
	unset($_SESSION['name']);
}

//add in the following, get a page #
  if (isset($_GET['page']))
	  $thispage = $_GET['page'];
  else
	  $thispage = 1;
  
$query1 = "SELECT count(*) FROM posts ";
$stmt = $dbc -> prepare($query1);
  $stmt->execute();
  $stmt->store_result();
    $stmt->bind_result($totrecords);
	$stmt->fetch();
	echo "<p>total records: " . $totrecords . "</p>";
$stmt->free_result();

$recordsperpage = 5;   //set the # of records that you want on each page that renders

$totalpages =  $totrecords/$recordsperpage;  // 1. how many pages are needed to show all the records
$offset =  ($thispage-1)*$recordsperpage;
 //2. Using $thispage and $recordsperpage which is the first record that should be returned on this page
 //so if it is page 2, then the first record would be record #5 (considering that records start at 0)

$query = "SELECT posts.Title, posts.Postbody, users.NickName, posts.date_time 
FROM posts,users WHERE posts.Userid_FK = users.Userid ORDER BY Postid DESC LIMIT ?,?";
$stmt = $dbc->prepare($query);
$stmt->bind_param('ss',$offset, $recordsperpage);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($Title, $Postbody, $name, $datet);

echo "<p> Showing ".$stmt->num_rows." books per page.</p>";


//add in the following, get a page #
  if (isset($_GET['page']))
	  $thispage = $_GET['page'];
  else
	  $thispage = 1;	
while ($stmt->fetch()){
	echo "<p><b>".$Title."</b><br/>".$Postbody."<br/>Post by: ".$name."<br/>".$datet."</p>";
	echo "<br/>";
}
$stmt->free_result();
$dbc->close();

//let user know how many page of post have
echo "total pages: ".$totalpages."<br />";

//let user know which page they on
echo "<br><p> Showing page ".$thispage." of total ".$totalpages." pages.</p>";

if ($thispage > 1)
   {
      $page = $thispage - 1;
	echo "<a href='index.php?page=$page'>Previous 5 posts</a> ";
} 
if ($thispage < $totalpages)  {
      $page = $thispage + 1;
     	echo "<a href='index.php?page=$page'>Next 5 posts</a>"; 
} 


/*
if ($thispage == 1)
   {
      $page = $thispage + 1;
	echo "<a href='index.php?$offset=$thispage&$recordsperpage=5&page=$page'>Next 5</a> ";
} 
else if($thispage >= $totalpages)  {
      $page = $thispage - 1;
     echo "<a href='index.php?$offset=$thispage&$recordsperpage=5&page=$page'>Previous 5</a>"; 
   } 
else{
	$page = $thispage - 1;
	echo "<a href='index.php?$offset=$thispage&$recordsperpage=5&page=$page'>Previous 5</a>";
	echo "\t";
	$page = $thispage + 1;
	echo "<a href='index.php?$offset=$thispage&$recordsperpage=5&page=$page'>Next 5</a> ";
     }
*/


//Building the Individual Page Links
/*After the Previous page link, we need to list each of the available data Web pages as links 
$bar = "";
if ($totalpages > 1)
{ 
    for($page = 1; $page <= $totalpages; $page++)
    {
        if ($page == $thispage){
           $bar .= "$page";
       } 
	else{
	 $link_address='index.php?$offset=$thispage&$recordsperpage=5&page='.$page;
       	$bar.= " <a href='".$link_address."'>$page</a> ";
	 //$bar .= "<a href='".'index.php?$offset=$thispage&$recordsperpage=5&page="'.$page.'"'."'>$page</a>";

       }
    }
echo $bar;
}*/

include('includes/footer.html');
?>