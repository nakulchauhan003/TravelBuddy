<?php
// Load configuration and database
require_once('includes/initialize.php');
?>

<div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 60px 0; text-align: center; color: white; margin-bottom: 50px;">
  <div class="container">
    <h1 style="font-size: 48px; margin: 0 0 20px 0; font-weight: bold;">Our Room Collections</h1>
    <p style="font-size: 18px; margin: 0; opacity: 0.95;">Discover luxurious accommodations designed for comfort and relaxation</p>
  </div>
</div>

<div class="container" style="margin-bottom: 80px;">
  <div class="row">
    <?php
    // Fetch all rooms from database
    $query = "SELECT r.ROOMID, r.ROOM, r.ROOMDESC, r.PRICE, r.NUMPERSON, r.ROOMIMAGE, a.ACCOMODATION, a.ACCOMDESC 
              FROM tblroom r 
              JOIN tblaccomodation a ON r.ACCOMID = a.ACCOMID 
              ORDER BY r.ACCOMID, r.ROOMID";
    
    $mydb->setQuery($query);
    $rooms = $mydb->loadResultList();
    
    $current_category = '';
    
    foreach ($rooms as $room) {
        // Add category header if it changed
        if ($room->ACCOMODATION !== $current_category) {
            if ($current_category !== '') {
                echo '</div></div></div>';
            }
            $current_category = $room->ACCOMODATION;
            echo '<div class="col-12" style="margin-top: 40px;"><h2 style="border-bottom: 3px solid #667eea; padding-bottom: 15px; color: #333; font-weight: bold;">' . htmlspecialchars($room->ACCOMODATION) . '</h2></div>';
            echo '<div class="row" style="width: 100%; margin: 0;">
                    <div class="col-12" style="margin-bottom: 20px; padding: 0;"><p style="color: #666; font-size: 14px;">' . htmlspecialchars($room->ACCOMDESC ?? '') . '</p></div>';
        }
        ?>
        
        <div class="col-lg-6 col-md-12" style="margin-bottom: 30px;">
          <div class="card" style="border: 1px solid #e0e0e0; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); height: 100%; transition: transform 0.3s ease;">
            
            <!-- Room Image -->
            <div style="height: 300px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); position: relative; overflow: hidden;">
              <?php if (!empty($room->ROOMIMAGE) && file_exists('admin/mod_room/' . $room->ROOMIMAGE)) { ?>
                <img src="<?php echo WEB_ROOT . 'admin/mod_room/' . htmlspecialchars($room->ROOMIMAGE); ?>" 
                     alt="<?php echo htmlspecialchars($room->ROOM); ?>" 
                     style="width: 100%; height: 100%; object-fit: cover;">
              <?php } else { ?>
                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: white; font-size: 18px;">
                  Hotel Room
                </div>
              <?php } ?>
            </div>
            
            <!-- Room Content -->
            <div class="card-body" style="padding: 25px;">
              <h3 style="color: #333; margin: 0 0 10px 0; font-weight: bold; font-size: 22px;">
                <?php echo htmlspecialchars($room->ROOM); ?>
              </h3>
              
              <div style="margin: 15px 0; padding-bottom: 15px; border-bottom: 1px solid #eee;">
                <p style="margin: 0; color: #666; font-size: 15px;">
                  <strong>Capacity:</strong> <?php echo htmlspecialchars($room->NUMPERSON); ?> 
                  <?php echo $room->NUMPERSON == 1 ? 'Person' : 'Persons'; ?>
                </p>
              </div>
              
              <div style="margin: 15px 0; padding-bottom: 15px; border-bottom: 1px solid #eee;">
                <p style="margin: 0; color: #555; line-height: 1.6; font-size: 14px;">
                  <?php echo htmlspecialchars($room->ROOMDESC ?? 'Comfortable accommodation'); ?>
                </p>
              </div>
              
              <!-- Pricing Section -->
              <div style="background: #f5f7fa; padding: 15px; border-radius: 8px; margin: 15px 0;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                  <div>
                    <p style="margin: 0; color: #999; font-size: 12px; text-transform: uppercase;">Price Per Night</p>
                    <p style="margin: 5px 0 0 0; font-size: 28px; color: #667eea; font-weight: bold;">
                      ₱<?php echo number_format($room->PRICE, 2); ?>
                    </p>
                  </div>
                  <div style="text-align: right; color: #999; font-size: 13px;">
                    Room ID: <?php echo htmlspecialchars($room->ROOMID); ?>
                  </div>
                </div>
              </div>
              
              <!-- Features/Amenities -->
              <div style="margin: 15px 0; padding: 15px; background: #f0f4ff; border-left: 4px solid #667eea;">
                <ul style="margin: 0; padding-left: 20px; color: #555; font-size: 14px;">
                  <li>Air-conditioned room</li>
                  <li>Private bathroom with hot water</li>
                  <li>Free WiFi</li>
                  <?php if (strpos(strtolower($room->ROOMDESC), 'tv') !== false) { ?>
                    <li>Television</li>
                  <?php } ?>
                </ul>
              </div>
              
              <!-- Book Now Button -->
              <form method="POST" action="<?php echo WEB_ROOT; ?>index.php?p=booking" style="margin-top: 20px;">
                <input type="hidden" name="ROOMID" value="<?php echo htmlspecialchars($room->ROOMID); ?>">
                <input type="hidden" name="accomodation" value="<?php echo htmlspecialchars($room->ACCOMODATION); ?>">
                <button type="submit" style="width: 100%; padding: 12px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 5px; font-size: 16px; font-weight: bold; cursor: pointer; transition: transform 0.2s;">
                  Book This Room
                </button>
              </form>
            </div>
          </div>
        </div>
        
        <?php
    }
    if ($current_category !== '') {
        echo '</div></div></div>';
    }
    ?>
  </div>
</div>

<!-- Additional Info Section -->
<div style="background: #f8f9fa; padding: 60px 0; margin-top: 40px;">
  <div class="container">
    <div class="row text-center">
      <div class="col-md-4" style="margin-bottom: 30px;">
        <div style="padding: 30px;">
          <div style="font-size: 40px; color: #667eea; margin-bottom: 15px;">🛏️</div>
          <h4 style="color: #333; margin-bottom: 10px;">Premium Bedding</h4>
          <p style="color: #666; margin: 0;">High-quality linens and pillows for ultimate comfort and restful sleep</p>
        </div>
      </div>
      <div class="col-md-4" style="margin-bottom: 30px;">
        <div style="padding: 30px;">
          <div style="font-size: 40px; color: #764ba2; margin-bottom: 15px;">📺</div>
          <h4 style="color: #333; margin-bottom: 10px;">Modern Amenities</h4>
          <p style="color: #666; margin: 0;">Air conditioning, satellite TV, mini-bar, and in-room entertainment systems</p>
        </div>
      </div>
      <div class="col-md-4" style="margin-bottom: 30px;">
        <div style="padding: 30px;">
          <div style="font-size: 40px; color: #667eea; margin-bottom: 15px;">🌊</div>
          <h4 style="color: #333; margin-bottom: 10px;">Ocean Views</h4>
          <p style="color: #666; margin: 0;">Experience breathtaking coastal vistas from select room categories</p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Contact/Booking Info -->
<div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 50px 0; text-align: center; margin-top: 40px;">
  <div class="container">
    <h2 style="margin-bottom: 20px; font-weight: bold;">Ready to Book Your Stay?</h2>
    <p style="font-size: 18px; margin-bottom: 30px; opacity: 0.95;">Choose your perfect room and start planning your dream vacation with us today!</p>
    <a href="<?php echo WEB_ROOT; ?>index.php?p=availability_search" style="display: inline-block; padding: 12px 40px; background: white; color: #667eea; text-decoration: none; border-radius: 5px; font-weight: bold; font-size: 16px; transition: transform 0.2s;">
      Search Availability
    </a>
  </div>
</div>
