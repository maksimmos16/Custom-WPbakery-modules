jQuery(document).ready(function ($) {
  // toggle the search form when the toggle button is clicked
  $(".mobile-search-toggle").on("click", function () {
    $(".mobile-search-form").toggleClass("open");
  });
});

// jQuery('.custom-products-slider').slick('slickSetOption', 'centerPadding', '140px');

jQuery(document).ready(function ($) {
  $(".custom-products").show();
  $(".best-selling-products-wrapper").show();
  $(".third-slider").show();
});

jQuery(document).ready(function ($) {
  $(".faq-accordeon").click(function () {
    $(this).toggleClass("vc_toggle_active");
    $(this).siblings().removeClass("vc_toggle_active");
    $(".vc_toggle_content").hide();
    $(".vc_toggle_active .vc_toggle_content").show();
  });

  // Show the content of the default active tab
  $(".vc_toggle_active .vc_toggle_content").show();
});

document.addEventListener("DOMContentLoaded", function () {
  var menu = document.querySelector(".menu-footer1");
  var firstItem = menu.querySelector(".menu-footer1 .menu-item:first-child");

  firstItem.addEventListener("click", function () {
    menu.classList.toggle("expanded");
  });
});

document.addEventListener("DOMContentLoaded", function () {
  var menu = document.querySelector(".menu-footer2");
  var firstItem = menu.querySelector(".menu-footer2 .menu-item:first-child");

  firstItem.addEventListener("click", function () {
    menu.classList.toggle("expanded");
  });
});

document.addEventListener("DOMContentLoaded", function () {
  var menu = document.querySelector(".menu-footer3");
  var firstItem = menu.querySelector(".menu-footer3 .menu-item:first-child");

  firstItem.addEventListener("click", function () {
    menu.classList.toggle("expanded");
  });
});

const toggleButton = document.querySelector(".navbar-toggler");
const mobileMenuHtml = document.querySelector(".mobile-menu-html");

toggleButton.addEventListener("click", function () {
  mobileMenuHtml.classList.toggle("mmh-show");
});

jQuery(document).ready(function ($) {
  $("#filter-link").click(function () {
    event.preventDefault();
    $(".wc-mobile-filters").toggle();
    $(this).toggleClass("active");
  });

  $("#sorting-link").click(function () {
    event.preventDefault();
    $(".wc-mobile-sorting").toggle();
    $(this).toggleClass("active");
  });
});

jQuery(document).ready(function ($) {
  $(".ajax_add_to_cart").click(function () {
    setTimeout(function () {
      $(".toast").toast("show");
    }, 1200); // 1000 milliseconds = 1 second
  });
});

jQuery(document).ready(function ($) {
  // Add click event listener to switcher buttons
  $(".one-col-m-product-view").click(function () {
    // Remove product-card-two class from all product cards
    $(".product-card").removeClass("product-card-two");
    // Remove two-col-products class from the products container
    $(".products").removeClass("two-col-products");
    $(".two-col-m-product-view").removeClass("wc-swither-active");
    $(".one-col-m-product-view").addClass("wc-swither-active");
  });

  $(".two-col-m-product-view").click(function () {
    // Add product-card-two class to all product cards
    $(".product-card").addClass("product-card-two");
    // Add two-col-products class to the products container
    $(".products").addClass("two-col-products");
    $(".two-col-m-product-view").addClass("wc-swither-active");
    $(".one-col-m-product-view").removeClass("wc-swither-active");
  });

  var productSwitcher = $(".product-switcher");
  var oneColBtn = productSwitcher.find(".one-col-m-product-view");
  var twoColBtn = productSwitcher.find(".two-col-m-product-view");

  if ($(".product-card").hasClass("product-card-two")) {
    twoColBtn.addClass("wc-swither-active");
  } else {
    oneColBtn.addClass("wc-swither-active");
  }
});

jQuery(document).ready(function ($) {
  // Get the quantity input element
  var quantityInput = $("input.qty");

  // Get the "Update cart" button element
  var updateCartButton = $('button[name="update_cart"]');

  // When the quantity input value changes
  quantityInput.on("input", function () {
    // Remove the "disabled" attribute from the "Update cart" button
    updateCartButton.removeAttr("disabled");
    updateCartButton.attr("aria-disabled", "false");
  });
});

jQuery(document).ready(function ($) {
  $(document).on("click", ".quantity .plus, .quantity .minus", function () {
    $('button[name="update_cart"]')
      .removeAttr("disabled")
      .attr("aria-disabled", "false");
  });
  $(".woocommerce-cart-form").on("submit", function () {
    $('button[name="update_cart"]')
      .attr("disabled", "disabled")
      .attr("aria-disabled", "true");
  });
});

jQuery(document).ready(function ($) {
  $("#mobile-menu-btn").on("click", function () {
    $(this).find(".mobile-menu-icon").toggle();
  });
});

jQuery(document).ready(function($) {
  // Get the close button element
  var closeButton = $('.close-button');

  // Get the subscription banner element
  var subscriptionBanner = $('.subscription-banner');

  // Add event listener to the close button
  closeButton.on('click', function() {
    // Hide the subscription banner
    subscriptionBanner.hide();
  });
});


// jQuery(document).ready(function($) {
//   // Add event listener to the Add to Cart button
//   $('.add_to_cart_button').on('click', function(e) {
//       e.preventDefault(); // Prevent default click behavior

//       var $button = $(this);

//       // Send AJAX request to reload the cart section
//       $.ajax({
//           url: ajax_object.ajax_url,
//           type: 'POST',
//           data: {
//               action: 'load_cart_fragment'
//           },
//           beforeSend: function() {
//               // Show a loading indicator if needed
//           },
//           success: function(response) {
//             var fragment = response.data.fragment;
//             var cartCount = response.data.cart_count;
//             var cartTotal = response.data.cart_total;

//             console.log(cartCount); // Log the cart_count value
//             console.log(cartTotal); // Log the cart_total value

//             // Replace the cart section with the updated content
//             $('.header-cart-container').html(fragment);
//             $('.header-cart-count').text(cartCount);
//             $('.header-cart-price').text(cartTotal);
//           },
//           error: function(xhr, status, error) {
//               console.log(error); // Handle error case if needed
//           }
//       });
//   });
// });

// var ajaxscript = { ajax_url: 'http://localhost/bicycle/wp-admin/admin-ajax.php' };

// jQuery(document).ready(function($) {
//   $('form.cart').on('submit', function(e) {
//     e.preventDefault(); // Prevent form submission

//     var $form = $(this);
//     var formData = $form.serialize(); // Get form data

//     // Make an AJAX request to add the product to the cart
//     $.ajax({
//       url: ajaxscript.ajax_url, // Absolute URL with protocol-independent form
//       method: 'POST',
//       data: formData + '&action=add_to_cart', // Append action parameter
//       dataType: 'json', // Set data type to JSON
//       beforeSend: function() {
//         // Show loading spinner or any other visual indication
//         // that the product is being added to the cart
//       },
//       success: function(response) {
//         // Handle the response from the AJAX request

//         // For example, you can display a success message
//         // or update the cart icon to reflect the new item count

//         // Reload the page (optional)
//         // You can remove this line if you don't want to reload the page
//         location.reload();
//       }
//     });
//   });
// });



jQuery(document).ready(function($) {
  $('.single-page-product-slider-for').on('init', function() {
    $('.single-page-product-slider-for, .single-page-product-slider-nav').css('visibility', 'visible');
  }).slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    fade: true,
    asNavFor: '.single-page-product-slider-nav'
  });

  $('.single-page-product-slider-nav').slick({
    slidesToShow: 4,
    slidesToScroll: 1,
    asNavFor: '.single-page-product-slider-for',
    dots: true,
    centerMode: false,
    focusOnSelect: true,
    prevArrow: false, // Hide the previous button
    nextArrow: false, // Hide the next button
    variableWidth: true // Enable variable width for the navigation slides
  });
});

// Initialize the lightbox
jQuery(document).ready(function($) {
  $('.single-page-product-slider-for').magnificPopup({
    delegate: 'a.lightbox-image',
    type: 'image',
    gallery: {
      enabled: true,
      arrowMarkup: '<button title="%title%" type="button" class="mfp-arrow mfp-arrow-%dir%"></button>'
    },
    mainClass: 'mfp-with-zoom',
    zoom: {
      enabled: true,
      duration: 300,
      easing: 'ease-in-out'
    },
    navigateByImgClick: true,
    arrowMarkup: '<button title="%title%" type="button" class="mfp-arrow mfp-arrow-%dir%"></button>'
  });
});



/* if product quantity = 1 disable - btn */
jQuery(document).ready(function($) {
  var qty_input = $('.qty');
  var minus_button = $('.minus');
  var plus_btn = $('.plus');

  // Check initial quantity value and disable minus button if it's 1
  checkQuantity();

  // Listen for changes in the quantity input
  qty_input.on('input', function() {
    checkQuantity();
  });

  plus_btn.on('click', function() {
    // alert('plus clicked');
    
    var qty_val = parseInt(qty_input.val());
    // alert(qty_val);
    if (qty_val > 1) {
      // Check quantity
      checkQuantity();
    }
  });

  // Button click event for the minus button
  minus_button.on('click', function() {
    var qty_val = parseInt(qty_input.val());
    // Check quantity after decrementing
    checkQuantity();
  });

  function checkQuantity() {
    var qty_val = parseInt(qty_input.val());
    if (qty_val === 1) {
      minus_button.prop('disabled', true);
    } else {
      minus_button.prop('disabled', false);
    }
  }
});

jQuery(document).ready(function($) {
  // Add event listener to close button
  $(document).on('click', '.woocommerce-error-close', function() {
      // Hide the error element when the close button is clicked
      $(this).closest('.woocommerce-error').hide();
  });
});

jQuery(document).ready(function($) {
  // Add event listener to close button
  $('.woocommerce-error-close').click(function() {
      // Hide the error element when the close button is clicked
      $('.woocommerce-notices-wrapper').hide();
  });
});

jQuery(document).ready(function($) {
  // Add event listener to close button
  $(document).on('click', '.woocommerce-success-close', function() {
      // Hide the error element when the close button is clicked
      $(this).closest('.woocommerce-success').hide();
  });
});



// Get the cart button element
const cartButton = document.querySelector('.header-cart');

// Get the popup cart container and its content elements
const popupCartContainer = document.getElementById('popup-cart-container');
const popupCartProducts = document.getElementById('popup-cart-products');
const popupCartTotal = document.getElementById('popup-cart-total');

let hidePopupTimeout; // Variable to store the timeout for hiding the popup cart

// Show the popup cart on hover
cartButton.addEventListener('mouseover', function() {
  clearTimeout(hidePopupTimeout); // Clear any existing timeout for hiding the popup cart

  // Get the cart data via AJAX
  fetch('/bicycle/wp-json/wc/store/cart') // Update the URL here
    .then(response => response.json())
    .then(data => {
      console.log(data); // Log the response data to the console

      // Extract the products and total price from the cart data
      const products = data.items;
      const totalPrice = parseFloat(data.totals.total_price) / 100; // Divide by 100 to convert cents to dollars

      // Clear the existing content
      popupCartProducts.innerHTML = '';
      popupCartTotal.innerHTML = '';

      // Populate the popup cart with the products
      products.forEach(product => {
        const productName = product.name;
        const productQuantity = product.quantity;
        const productImage = product.images[0].src; // Assuming the first image is used

        // Create the product element
        const productElement = document.createElement('div');
        
        // Create the product image element and set the source
        const productImageElement = document.createElement('img');
        productImageElement.src = productImage;
        productImageElement.classList.add('product-image');
        productElement.appendChild(productImageElement);

        // Create the product name element and set the text content
        const productNameElement = document.createElement('a');
        productNameElement.textContent = productName;
        productNameElement.href = product.permalink; // Set the product permalink as the link
        productElement.appendChild(productNameElement);

        // Create the product quantity element and set the text content
        const productQuantityElement = document.createElement('span');
        productQuantityElement.textContent = `(Menge: ${productQuantity})`;
        productElement.appendChild(productQuantityElement);

        popupCartProducts.appendChild(productElement);
      });

      // Populate the popup cart with the total price
      popupCartTotal.textContent = `Gesamtpreis: $${totalPrice.toFixed(2)}`; // Format the total price as a currency value
    });

  popupCartContainer.style.display = 'block';
});

// Hide the popup cart with a delay when the mouse leaves the button or the popup cart
function hidePopupCart() {
  hidePopupTimeout = setTimeout(function() {
    popupCartContainer.style.display = 'none';
  }, 500); // Adjust the delay here (in milliseconds)
}

// Clear the timeout for hiding the popup cart when the mouse enters the popup cart container
popupCartContainer.addEventListener('mouseenter', function() {
  clearTimeout(hidePopupTimeout);
});

cartButton.addEventListener('mouseleave', hidePopupCart);
popupCartContainer.addEventListener('mouseleave', hidePopupCart);




// jQuery(document).ready(function($) {
//   var timeout;

//   $('.menu-item-has-children').mouseenter(function() {
//     clearTimeout(timeout);
//     var dropdownMenu = $(this).find('.dropdown-menu').first();
//     if (!dropdownMenu.hasClass('show')) {
//       $('.dropdown-menu').removeClass('show-submenu');
//       dropdownMenu.addClass('show-submenu');
//     }
//   });

//   $('.menu-item-has-children').mouseleave(function() {
//     var submenu = $(this).find('.dropdown-menu').first();
//     timeout = setTimeout(function() {
//       submenu.removeClass('show-submenu');
//     }, 1500);
//   });

//   $(document).on('click', function(event) {
//     var target = $(event.target);

//     // Check if the clicked element is outside the menu
//     if (!target.closest('.menu-item-has-children').length) {
//       $('.dropdown-menu').removeClass('show-submenu');
//     }
//   });
// });




/* 3 level menu mobile */
jQuery(document).ready(function($) {
  // Function to handle responsive behavior
  function handleResponsiveMenu() {
    if ($(window).width() < 767) {
      // Add the show class to second level dropdown menus
      $('.dropdown-menu .dropdown-menu').addClass('show');
      
      // Add the second-dropdown-mobile class to second level dropdown menus
      $('.dropdown-menu .dropdown-menu').addClass('second-dropdown-mobile');
    } else {
      // Remove the show class from second level dropdown menus
      $('.dropdown-menu .dropdown-menu').removeClass('show');
      
      // Remove the second-dropdown-mobile class from second level dropdown menus
      $('.dropdown-menu .dropdown-menu').removeClass('second-dropdown-mobile');
    }
  }
  
  // Call the function on page load
  handleResponsiveMenu();
  
  // Call the function on window resize
  $(window).resize(function() {
    handleResponsiveMenu();
  });
});


