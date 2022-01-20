<?php 
    if(isset($_SESSION['title']) && $_SESSION['title'] != "")
    {
?>
<script>
        swal({
            title: "<?php echo $_SESSION['title']; ?>",
            text: "<?php echo $_SESSION['text']; ?>",
            icon: "<?php echo $_SESSION['icon']; ?>"
        });
</script>
<?php 
        unset($_SESSION['title']);
    }
?>