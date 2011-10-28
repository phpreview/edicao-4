<?php 
if(!empty($notice)){
 echo "<p style='border:1px solid #FFCC00; background-color:#FFFFCC; font-weight:bold; padding:4px;'>".$notice."</p>";
 } 
?>
 

<h1>CONTACT FORM</h1>
 
<form action="" method="post">
 
<p><strong>Name:*</strong>
    <input name="name" type="text" id="name" value="<?php echo $fields['name'] ?>" />
 </p>

 <p><strong>Email:*</strong>
    <input name="email" type="text" id="email" value="<?php echo $fields['email'] ?>" />
 </p>
 
<p><strong>Message:*</strong>
    <textarea name="message" rows="4" id="message"><?php echo $fields['message'] ?></textarea>
 </p>
 
<p><input type="submit" name="Submit" value="Submit" />
 </p>

 </form>