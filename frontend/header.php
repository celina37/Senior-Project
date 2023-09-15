<?php
   include('C:\xampp\htdocs\ISDProject\backend\filter.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="/ISDProject/frontend/style.css">
<style>
 .hide-arrow::after {
        display: none !important;
    }
  .nav1bar {
    z-index: 10001;
  }
</style>
</head>

<body>
<nav id="first-navbar" class="navbar navbar-expand-lg bg-white pt-2 nav1bar">
  <div class="container-fluid" id="content">
    <div class="d-flex ms-auto navbar-brand justify-content-center">
      <ul class="navbar-nav flex-row">
      <li class="nav-item">
        <a class="nav-link" href="index.php?gender=1" onclick="genderS(1)">Women</a>        
      </li>
      <li class="nav-item">
        <a class="nav-link" href="index.php?gender=0" onclick="genderS(0)">Men</a>
      </li>
    </div>
    <a class="navbar-brand mx-auto d-flex justify-content-center w-100" href="../frontend/home.php">
      <img src="/ISDProject/logoISDcropped.jpeg" width="130" height="60" class="" alt="">
    </a>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav flex-row">
      <?php if (isset($_SESSION['id'])) { ?>
    <div class="dropdown">
        <button class="btn btn-link dropdown-toggle hide-arrow" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="bi bi-person-fill"></i>
        </button>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="../frontend/editprofile.php">Account Settings</a>
            <a class="dropdown-item" href="../frontend/yourorders.php">Your Orders</a>

            <a class="dropdown-item" href="../logout.php">Logout</a>
        </div>
    </div>
<?php } else { ?>
    <a class="btn btn-link" href="/ISDProject/login_register.php">
        <i class="bi bi-person-fill"></i>
    </a>
<?php } ?>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="Cart.php">
            <i class="bi bi-cart3"></i>
          </a>
        </li>
      </ul>
    </div>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  </div>
</nav>

<nav class="navbar navbar-expand-lg navbar-light bg-white" id="second-navbar" id="content">
  <div class="container-fluid">
    <div class="navbar-collapse justify-content-center" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="index.php?gender=<?php echo $gender?>" onclick="genderS(<?php echo $gender ?>)">Shop All</a>
        </li>
        <?php
        if (!empty($_SESSION['category_info'])) {
            foreach ($_SESSION['categoryItems'] as $categoryItem) {
                $categoryID = $categoryItem['category_id'];
                $categoryName = $categoryItem['category_name'];
                $subcategoryItems = array_filter($_SESSION['subcategoryItems'], function($subcategory) use ($categoryID) {
                    return $subcategory['cat_id'] == $categoryID;
                });
              if (!empty($subcategoryItems)) {
        ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <?php echo $categoryName; ?>
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink" id="filtered-data">
            <?php foreach ($subcategoryItems as $subcategory) { ?>
            <li>
              <a class="dropdown-item" href="index.php" onclick="SubcatS(<?php echo $subcategory['subcategory_id']; ?>, <?php echo $gender; ?>)"><?php echo $subcategory['subcategory_name']; ?></a>
            </li>
            <?php } ?>
          </ul>
        </li>
        <?php } } }
        ?>
        <li class="nav-item">
          <a class="nav-link" href="/ISDProject/frontend/giftcard.php">Gift card</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

</body>

</html>


<script>
// function openCartModal() {
//   var xhr = new XMLHttpRequest();
//   xhr.open("GET", "Cart.php");
//   xhr.onload = function() {
//     if (xhr.status === 200) {
//       var modal = document.createElement("div");
//       modal.classList.add("modal");

//       var modalContent = document.createElement("div");
//       modalContent.classList.add("modal-content");
//       modalContent.innerHTML = xhr.responseText;
//       modal.appendChild(modalContent);

//       var closeButton = document.createElement("button");
//       closeButton.classList.add("modal-close");
//       closeButton.textContent = "Close";
//       closeButton.onclick = function() {
//         document.body.removeChild(modal);
//         document.body.removeChild(overlay);
//         document.body.classList.remove("modal-open");
//       };
//       modalContent.appendChild(closeButton);

//       var overlay = document.createElement("div");
//       overlay.classList.add("modal-overlay");
//       overlay.onclick = function() {
//         document.body.removeChild(modal);
//         document.body.removeChild(overlay);
//         document.body.classList.remove("modal-open");
//       };
//       document.body.appendChild(overlay);

//       document.body.appendChild(modal);
//       document.body.classList.add("modal-open");
//     }
//   };
//   xhr.send();
// }



function genderS(genderId) {
  const currentURL = window.location.href;
  const baseURL = currentURL.split('?')[0];
  const newURL = baseURL + '?gender=' + genderId;
  history.pushState({}, '', newURL);
  const xhr = new XMLHttpRequest();
  xhr.open('GET', '../backend/filter.php?gender=' + genderId);
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4 && xhr.status === 200) {
      // alert("Success,gender Selected: " + genderId);
    }
  };
  xhr.send();
  location.reload();
}

function SubcatS(subcatID, genderId) {
  const currentURL = window.location.href;
  const baseURL = currentURL.split('?')[0];
  const newURL = baseURL + '?gender=' + genderId + '&subcat_id=' + subcatID;
  history.pushState({}, '', newURL);
  const xhr = new XMLHttpRequest();
  xhr.open('GET', '../backend/filter.php?gender=' + genderId + '&subcat_id=' + subcatID);
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4 && xhr.status === 200) {
      // alert("Subcategory Selected: " + subcatID + " Gender: " + genderId);
      window.location.href = 'index.php?gender=' + genderId + '&subcat_id=' + subcatID;
    }
  };
  xhr.send();
}



</script>

