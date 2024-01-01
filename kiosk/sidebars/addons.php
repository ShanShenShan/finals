
<?php require "headings.php"; ?>
<!--Removing headings-->
            <div class="container">

                    <header>
                        
                        <div class="title">PRODUCT LIST</div>

                        <div class="icon-cart">

                            <i class='bx bx-cart'></i>
                            <span>0</span>

                        </div>
                       
                    </header>

                    <div class="listProduct">
                        
                        <div class="item">

                            <img src="../image/foods.jpg" alt="">

                            <h5>NAME PRODUCT</h5>

                            <div class="price">₱59</div>
                            
                            <button class="addCart">
                                Add To Cart
                            </button>

                        </div>

                    </div>

            </div>

            <div class="cartTab">

                <h1>Order Status</h1>

                <div class="listCart">

                    <div class="item">

                        <img src="../image/foods.jpg" alt="">

                        <div class="name">

                            <div class="name">NAME</div>
                            <div class="variant">VARIANT</div>
                            
                        </div>

                        <div class="totalPrice">
                            ₱ 59
                        </div>

                        <div class="quantity">
                            <span class="minus"><</span>
                            <span>1</span>
                            <span class="plus">></span>   
                 </div>

                        <i class='bx bx-trash icon'></i>


                    </div>

                </div>

                <div class="btn">
                    <button class="close">CLOSE</button>
                    <button class="checkOut" id="checkOut">CHECK OUT</button>
                </div>

            </div>

            <div class="modal" id="ShowModal" tabindex="-1" aria-labelledby="ShowModal1" aria-hidden="true" style="display: none;">
                <div class="h1-text">
                    <h4>Are you sure to proceed <br> to check out your orders?</h4>
                </div>
                
                <button class="btn" id="no">No</button>
                <button class="btn" id="yes">Yes</button>
                
            </div>
            
            <div class="modal2" id="ShowModal2" tabindex="-1" aria-labelledby="ShowModal2" aria-hidden="true" style="display: none;">
                <div class="h1-text">
                    <h4>Your order is being processed</h4>
                    <p>Please submit this order ID to the counter section. Thank you!</p>
                </div>
                
                <button class="btn" id="understand">I understand</button>
                
            </div>

            <div class="modal3" id="ShowModal3" tabindex="-1" aria-labelledby="ShowModal3" aria-hidden="true" style="display: none;">
                <div class="item">
                    <img src="../image/foods.jpg" alt="">
                    <h4>NAME PRODUCT</h4>
                    <h5>Category</h5>
                    <div class="price">₱59</div>
                    
                    <div class="description">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Quo eaque odit iste minima consectetur, sit, saepe iure quia porro cum optio ducimus exercita
                    </div>
                        
                    <div class="buttons">
                        <button class="btn" id="close">
                            Close
                        </button>
                                            
                        <button class="btn" id="addToCart">
                           Add To Cart
                        </button>
                    </div>
                </div>
            </div>

            
        <script src="../js/app.js"></script>
    </body>

</html>