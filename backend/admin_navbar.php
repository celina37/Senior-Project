<?php
include ('C:\xampp\htdocs\ISDProject\resources.php');
include('C:\xampp\htdocs\ISDProject\db_connect.php');
?>
<!DOCTYPE html>
<html>
<head>
  <title></title>
  <style>
  body {
    background-color: #f9f3fd;
    margin: 0;
  }

  .navbar-custom {
    background-color: #ffffff;
  }

  .navbar-nav .nav-link i {
    color: #463c74;
    font-size: 24px;
    margin-left: 10px;
  }
  .sidebar-link.active {
  background-color: #f4e6fb;
  text-decoration: none;
  color: #463c74;
}

  .sidebar {
    position: fixed;
    top: 70px;
    left: -250px; /* Updated initial position */
    width: 250px;
    height: 100%;
    background-color: #ffffff;
    overflow: hidden;
  }
  
  .sidebar-open {
    left: 0;
  }

  .navbar-welcome {
    font-family: 'Brush Script MT', cursive;
    font-size: 30px;
    color: #463c74;
    margin-left: 30px;
    width:20%;
  }
  .sidebar-title {
    font-size: 20px;
    color: #463c74;
    margin: 20px 0;
    padding: 0 20px;
  }

  .sidebar-link {
    display: block;
    font-size: 18px;
    color: #5f5ca8;
    text-decoration: none;
    padding: 10px 20px;
    transition: background-color 0.3s ease;
  }

  .sidebar-link:hover {
    background-color: #f4e6fb;
    text-decoration: none;
    color: #463c74;


  }
 

  .content-container {
    margin-left: 0;
  }

  .sidebar-open ~ .content-container {
    margin-left: 130px;
  }

  .content {
    max-width: calc(100% - 130px);
    margin: 0 auto;
    padding: 20px;
  }
</style>

  
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light navbar-custom">
    <button class="sidebar-toggle" onclick="toggleSidebar()">
      <i class="bi bi-list"></i>
    </button>
    <span class="navbar-welcome">Welcome <?php echo $fname; ?></span>
    <a class="navbar-brand mx-auto d-flex justify-content-center w-100" href="../backend/admin_dashboard.php">
      <img src="/ISDProject/logoISDcropped.jpeg" width="130" height="60" class="" alt="">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="../backend/editprofile.php" data-toggle="tooltip" data-placement="bottom" title="Account Settings">
            <i class="bi bi-person-fill"></i>
          </a>
        </li>
        <li class="nav-item">

          <a class="nav-link" href="../logout.php" data-toggle="tooltip" data-placement="bottom" title="Logout">
            <i class="bi bi-box-arrow-right"></i>
          </a>
        </li>
      </ul>
    </div>
  </nav>

  <div class="sidebar">

  <a id="link0" class="sidebar-link mt-5"  href="../backend/admin_dashboard.php" onclick="setActiveLink(this)">Dashboard</a>

  <hr>
    <h3 class="sidebar-title">Manage Categories</h3>
    <hr>
    <a id="link1" class="sidebar-link" href="../backend/category.php" onclick="setActiveLink(this)">Add/All Category</a>
<a id="link2" class="sidebar-link" href="../backend/subcategory.php" onclick="setActiveLink(this)">Add/All Subcategory</a>
    <hr>
    <h3 class="sidebar-title">Manage Products</h3>
    <hr>
    <a id="link3" class="sidebar-link" href="../backend/addproduct.php" onclick="setActiveLink(this)">Add Product</a>
<a id="link4" class="sidebar-link" href="../backend/allproducts.php" onclick="setActiveLink(this)">All/Edit Product</a>
  </div>

  <!-- Add a container div to wrap the content -->
  <div class="content-container">
    <div class="content">


  <!-- Add custom script for sidebar toggle -->
<script>
  function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar');
    const contentContainer = document.querySelector('.content-container');

    sidebar.classList.toggle('sidebar-open');
    contentContainer.classList.toggle('sidebar-open');

    if (sidebar.classList.contains('sidebar-open')) {
      localStorage.setItem('sidebarState', 'open');
    } else {
      localStorage.setItem('sidebarState', 'closed');
    }
  }

  // Check the sidebar state on page load
  document.addEventListener('DOMContentLoaded', function() {
    const sidebarState = localStorage.getItem('sidebarState');
    if (sidebarState === 'open') {
      const sidebar = document.querySelector('.sidebar');
      const contentContainer = document.querySelector('.content-container');
      sidebar.classList.add('sidebar-open');
      contentContainer.classList.add('sidebar-open');
    }
  });
</script>



<script>
  function setActiveLink(link) {
    const links = document.querySelectorAll('.sidebar-link');
    links.forEach((item) => {
      item.classList.remove('active');
    });
    link.classList.add('active');
  }

  // Check the sidebar state on page load
  document.addEventListener('DOMContentLoaded', function() {
    const sidebarState = localStorage.getItem('sidebarState');
    if (sidebarState === 'open') {
      const sidebar = document.querySelector('.sidebar');
      const contentContainer = document.querySelector('.content-container');
      sidebar.classList.add('sidebar-open');
      contentContainer.classList.add('sidebar-open');
    }

    // Set active link based on the current URL
    const currentUrl = window.location.href;
    const links = document.querySelectorAll('.sidebar-link');
    links.forEach((link) => {
      if (link.href === currentUrl) {
        link.classList.add('active');
      }
    });
  });
</script>
