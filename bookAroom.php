<?php
$msg = '';
$error = '';
$searched = false;
$availableRooms = [];

if (!function_exists('h')) {
    function h($value)
    {
        return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
    }
}

if (isset($_POST['booknow'])) {
    if (isset($_SESSION['arrival'], $_SESSION['departure'], $_POST['ROOMID'], $_POST['ROOMPRICE'])) {
        $day = dateDiff($_SESSION['arrival'], $_SESSION['departure']);
        $days = ($day <= 0) ? 1 : $day;
        $totalPrice = (float)$_POST['ROOMPRICE'] * $days;

        addtocart((int)$_POST['ROOMID'], $days, $totalPrice, $_SESSION['arrival'], $_SESSION['departure'], 0);
        redirect(WEB_ROOT . 'booking/');
    } else {
        $error = 'Please search availability first before booking a room.';
    }
}

$defaultArrival = isset($_SESSION['arrival']) ? $_SESSION['arrival'] : date('Y-m-d');
$defaultDeparture = isset($_SESSION['departure']) ? $_SESSION['departure'] : date('Y-m-d');

$selectedArrival = isset($_POST['arrival']) ? trim($_POST['arrival']) : $defaultArrival;
$selectedDeparture = isset($_POST['departure']) ? trim($_POST['departure']) : $defaultDeparture;
$selectedAccomodation = isset($_POST['accomodation']) ? trim($_POST['accomodation']) : '';
$selectedPerson = isset($_POST['person']) ? (int)$_POST['person'] : 0;

$accomodation = new Accomodation();
$accomodationList = $accomodation->listOfaccomodation();

$mydb->setQuery("SELECT DISTINCT(`NUMPERSON`) AS NumberPerson FROM `tblroom` ORDER BY NumberPerson ASC");
$personOptions = $mydb->loadResultList();

if (isset($_POST['checkAvail'])) {
    $searched = true;

    if ($selectedArrival === '' || $selectedDeparture === '' || $selectedAccomodation === '' || $selectedPerson <= 0) {
        $error = 'Please fill all booking search fields.';
    } else {
        $arrivalObj = date_create($selectedArrival);
        $departureObj = date_create($selectedDeparture);

        if (!$arrivalObj || !$departureObj) {
            $error = 'Invalid date selected. Please try again.';
        } else {
            $_SESSION['arrival'] = date_format($arrivalObj, 'Y-m-d');
            $_SESSION['departure'] = date_format($departureObj, 'Y-m-d');

            $days = dateDiff($_SESSION['arrival'], $_SESSION['departure']);
            if ($days <= 0) {
                $msg = 'Available rooms for today';
            } else {
                $msg = 'Available rooms from ' . date_format($arrivalObj, 'M d, Y') . ' to ' . date_format($departureObj, 'M d, Y');
            }

            $query = "SELECT * FROM `tblroom` r
                      INNER JOIN `tblaccomodation` a ON r.`ACCOMID` = a.`ACCOMID`
                      WHERE a.`ACCOMODATION` = '" . addslashes($selectedAccomodation) . "'
                      AND r.`NUMPERSON` = " . (int)$selectedPerson . "
                      ORDER BY r.`PRICE` ASC";

            $mydb->setQuery($query);
            $rooms = $mydb->loadResultList();

            $arrival = $_SESSION['arrival'];
            $departure = $_SESSION['departure'];

            foreach ($rooms as $room) {
                $overlapQuery = "SELECT * FROM `tblreservation`
                    WHERE ((
                        '" . $arrival . "' >= DATE_FORMAT(`ARRIVAL`, '%Y-%m-%d')
                        AND '" . $arrival . "' <= DATE_FORMAT(`DEPARTURE`, '%Y-%m-%d')
                    )
                    OR (
                        '" . $departure . "' >= DATE_FORMAT(`ARRIVAL`, '%Y-%m-%d')
                        AND '" . $departure . "' <= DATE_FORMAT(`DEPARTURE`, '%Y-%m-%d')
                    )
                    OR (
                        DATE_FORMAT(`ARRIVAL`, '%Y-%m-%d') >= '" . $arrival . "'
                        AND DATE_FORMAT(`ARRIVAL`, '%Y-%m-%d') <= '" . $departure . "'
                    ))
                    AND ROOMID = " . (int)$room->ROOMID;

                $mydb->setQuery($overlapQuery);
                $reserved = $mydb->loadResultList();
                $remaining = (int)$room->OROOMNUM - count($reserved);
                $room->remaining = max(0, $remaining);
                $availableRooms[] = $room;
            }

            if (count($availableRooms) === 0) {
                $msg = 'No room matched your selected accommodation and number of persons.';
            }
        }
    }
}
?>

<style>
  .tb-booking-shell {
    margin-top: 24px;
    border-radius: 24px;
    overflow: hidden;
    border: 1px solid #e2e8f0;
    background: #f8fafc;
    box-shadow: 0 18px 40px rgba(15, 23, 42, 0.12);
  }
  .tb-booking-hero {
    padding: 44px 24px;
    background: linear-gradient(130deg, #0f172a, #1d4ed8 55%, #0ea5a4);
    color: #ffffff;
  }
  .tb-booking-hero h1 {
    margin: 0;
    font-size: clamp(1.8rem, 4.2vw, 3rem);
    line-height: 1.08;
    font-weight: 900;
  }
  .tb-booking-hero p {
    margin-top: 12px;
    max-width: 780px;
    color: #dbeafe;
    line-height: 1.65;
  }
  .tb-booking-body {
    padding: 24px;
  }
  .tb-search {
    background: #ffffff;
    border: 1px solid #dbe2ee;
    border-radius: 16px;
    padding: 18px;
    box-shadow: 0 10px 24px rgba(15, 23, 42, 0.08);
  }
  .tb-grid {
    display: grid;
    grid-template-columns: repeat(5, minmax(0, 1fr));
    gap: 12px;
    align-items: end;
  }
  .tb-field label {
    display: block;
    font-size: 12px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: #334155;
    margin-bottom: 6px;
  }
  .tb-field input,
  .tb-field select {
    width: 100%;
    border: 1px solid #cbd5e1;
    border-radius: 10px;
    padding: 10px 11px;
    background: #fff;
    color: #0f172a;
  }
  .tb-search-btn {
    border: 0;
    border-radius: 10px;
    padding: 11px 14px;
    font-weight: 800;
    color: #fff;
    background: linear-gradient(130deg, #2563eb, #0ea5a4);
    cursor: pointer;
    width: 100%;
  }
  .tb-alert {
    margin-top: 14px;
    padding: 10px 12px;
    border-radius: 10px;
    font-size: 14px;
  }
  .tb-alert.error {
    border: 1px solid #fecaca;
    background: #fef2f2;
    color: #b91c1c;
  }
  .tb-alert.success {
    border: 1px solid #bbf7d0;
    background: #f0fdf4;
    color: #166534;
  }
  .tb-results-title {
    margin: 24px 0 12px;
    font-size: 1.3rem;
    font-weight: 900;
    color: #0f172a;
  }
  .tb-cards {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 14px;
  }
  .tb-card {
    background: #fff;
    border: 1px solid #dbe2ee;
    border-radius: 14px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    box-shadow: 0 10px 24px rgba(15, 23, 42, 0.07);
  }
  .tb-card img {
    width: 100%;
    height: 190px;
    object-fit: cover;
    display: block;
  }
  .tb-card-body {
    padding: 14px;
  }
  .tb-card-body h3 {
    margin: 0;
    font-size: 1.2rem;
    color: #0f172a;
    font-weight: 800;
  }
  .tb-card-body p {
    margin: 8px 0;
    color: #475569;
    line-height: 1.55;
    font-size: 14px;
  }
  .tb-meta {
    font-size: 13px;
    color: #334155;
    margin: 3px 0;
  }
  .tb-price {
    margin-top: 8px;
    font-size: 1.35rem;
    font-weight: 900;
    color: #1d4ed8;
  }
  .tb-book-btn {
    margin-top: 10px;
    width: 100%;
    border: 0;
    border-radius: 10px;
    padding: 10px 12px;
    font-weight: 800;
    color: #fff;
    background: linear-gradient(130deg, #f97316, #ea580c);
    cursor: pointer;
  }
  .tb-book-btn[disabled] {
    background: #94a3b8;
    cursor: not-allowed;
  }
  @media (max-width: 1100px) {
    .tb-grid {
      grid-template-columns: repeat(2, minmax(0, 1fr));
    }
    .tb-cards {
      grid-template-columns: repeat(2, minmax(0, 1fr));
    }
  }
  @media (max-width: 680px) {
    .tb-booking-hero,
    .tb-booking-body {
      padding: 16px;
    }
    .tb-grid,
    .tb-cards {
      grid-template-columns: 1fr;
    }
  }
</style>

<div class="tb-booking-shell">
  <section class="tb-booking-hero">
    <h1>Book Your Room In Minutes</h1>
    <p>Search by date, accommodation, and number of guests. View real room availability and book instantly to your cart.</p>
  </section>

  <div class="tb-booking-body">
    <?php check_message(); ?>

    <form class="tb-search" method="POST" action="index.php?p=booking">
      <div class="tb-grid">
        <div class="tb-field">
          <label for="arrival">Arrival</label>
          <input type="date" id="arrival" name="arrival" value="<?php echo h($selectedArrival); ?>" required>
        </div>

        <div class="tb-field">
          <label for="departure">Departure</label>
          <input type="date" id="departure" name="departure" value="<?php echo h($selectedDeparture); ?>" required>
        </div>

        <div class="tb-field">
          <label for="accomodation">Accommodation</label>
          <select id="accomodation" name="accomodation" required>
            <option value="">Select</option>
            <?php foreach ($accomodationList as $item): ?>
              <?php $selected = ($selectedAccomodation === $item->ACCOMODATION) ? 'selected' : ''; ?>
              <option value="<?php echo h($item->ACCOMODATION); ?>" <?php echo $selected; ?>><?php echo h($item->ACCOMODATION); ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="tb-field">
          <label for="person">Guests</label>
          <select id="person" name="person" required>
            <option value="">Select</option>
            <?php foreach ($personOptions as $item): ?>
              <?php $value = (int)$item->NumberPerson; ?>
              <?php $selected = ($selectedPerson === $value) ? 'selected' : ''; ?>
              <option value="<?php echo $value; ?>" <?php echo $selected; ?>><?php echo $value; ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div>
          <button class="tb-search-btn" type="submit" name="checkAvail">Check Availability</button>
        </div>
      </div>
    </form>

    <?php if ($error !== ''): ?>
      <div class="tb-alert error"><?php echo h($error); ?></div>
    <?php endif; ?>

    <?php if ($msg !== ''): ?>
      <div class="tb-alert success"><?php echo h($msg); ?></div>
    <?php endif; ?>

    <?php if ($searched): ?>
      <h2 class="tb-results-title">Available Rooms</h2>

      <?php if (count($availableRooms) === 0): ?>
        <div class="tb-alert error">No rooms available for the selected criteria.</div>
      <?php else: ?>
        <div class="tb-cards">
          <?php foreach ($availableRooms as $room): ?>
            <article class="tb-card">
              <img src="<?php echo WEB_ROOT . 'admin/mod_room/' . h($room->ROOMIMAGE); ?>" alt="<?php echo h($room->ROOM); ?>">
              <div class="tb-card-body">
                <h3><?php echo h($room->ROOM); ?></h3>
                <p><?php echo h($room->ROOMDESC); ?></p>
                <div class="tb-meta"><strong>Accommodation:</strong> <?php echo h($room->ACCOMODATION); ?></div>
                <div class="tb-meta"><strong>Guests:</strong> <?php echo h($room->NUMPERSON); ?></div>
                <div class="tb-meta"><strong>Remaining Rooms:</strong> <?php echo (int)$room->remaining; ?></div>
                <div class="tb-price">&#8369;<?php echo number_format((float)$room->PRICE, 2); ?> <span style="font-size:12px;color:#475569;">/ night</span></div>

                <form method="POST" action="index.php?p=booking">
                  <input type="hidden" name="ROOMID" value="<?php echo (int)$room->ROOMID; ?>">
                  <input type="hidden" name="ROOMPRICE" value="<?php echo h($room->PRICE); ?>">
                  <button class="tb-book-btn" type="submit" name="booknow" <?php echo ($room->remaining <= 0) ? 'disabled' : ''; ?>>
                    <?php echo ($room->remaining <= 0) ? 'Fully Booked' : 'Book Now'; ?>
                  </button>
                </form>
              </div>
            </article>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    <?php endif; ?>
  </div>
</div>
