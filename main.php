<?php
include("language.php");
?>

<!DOCTYPE html>
<html lang="<?php echo $_SESSION['slang']; ?>">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="fragment" content="!">

    <link rel="shortcut icon" href="../../assets/ico/favicon.png">

    <title>osm24</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/leaflet.css" />
    <link rel="stylesheet" href="css/MarkerCluster.css"/>
    <link rel="stylesheet" href="css/MarkerCluster.Default.css"/>
    <link rel="stylesheet" href="css/leaflet.contextmenu.css"/>
    <link rel="stylesheet" href="css/Control.NominatimGeocoder.css"/>
    <link href="css/slider.css" rel="stylesheet">
    <link href="css/datepicker.css" rel="stylesheet">
    <!--[if lte IE 8]>
      <link rel="stylesheet" href="https://cdn.leafletjs.com/leaflet-0.6.4/leaflet.ie.css" />
    <![endif]-->

    <script src="js_lang.php?cache=<?php echo $_SESSION['lang'];?>"></script>
    <script src="https://code.jquery.com/jquery-2.0.2.js">{"parsetags": "explicit"}</script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/leaflet.js"></script>
    <script src="js/leaflet.markercluster.js"></script>
    <script src="js/leaflet-hash.js"></script>
    <script src="js/leaflet-timeslider.js"></script>
    <script src="js/Control.NominatimGeocoder.js"></script>
    <script src="js/suncalc.js"></script>
    <script src="js/snap.min.js"></script>
    <script src="js/leaflet.label.min.js"></script>
    <script src="js/bootstrap-slider.js"></script>
    <script src="js/bootstrap-datepicker.js"></script>
    <script src="js/leaflet.contextmenu.js"></script>
    <?php
      if(isset($_GET['id'])){
        $id=intval($_GET['id']);
        if($_GET['id'][0]=='w')
          $id='w'.intval(substr($_GET['id'],1));
        echo "<script type=\"text/javascript\">var permalink_object_id='".$id."';</script>";
      }
      if(isset($_GET['locate'])){
        echo "<script type=\"text/javascript\">var get_locate=1;</script>";
      }
    ?>
    <script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
    <script src="js/easyoverpass.js"></script>
    <script src="js/opening_hours+deps.min.js"></script>
    <link href="css/style.css" rel="stylesheet">
    <link href="css/leaflet.label.css" rel="stylesheet">
  </head>
  <body>
  <div class="snap-drawers">
    <div class="snap-drawer snap-drawer-left">
      <h4>POI List</h4>
      <div class="item active">
        <ul class="list-group scroll-menu" id="poilist">
        </ul>
      </div>
      <button class="btn navbar-btn" id="export_csv"><i class="glyphicon glyphicon-export"></i></button>
    </div>
  </div>

  <div id="content" class="snap-content" style="padding-top: 50px;">
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
           <button type="button" class="navbar-toggle" style="height:40px;color:white" data-toggle="collapse" data-target=".navbar-collapse">
-            Menu
-          </button><table><tr><td>
          <a id="open-left"></a></td><td>
          <i class="navbar-brand">osm24</i></td></tr></table>
        </div>
        <div class="collapse navbar-collapse global-menu-data">
          <ul class="nav navbar-nav">
            <li class="dropdown  btn-group btn-group-own ">
              <a class="dropdown-toggle btn-select" id="type" data-toggle="dropdown"><?php echo PANEL_EAT;?><span class="caret"></span></a>
              <ul class="dropdown-menu select-one-change sort">
                <li><a id="all"  data-tag-pair="['amenity'='restaurant']@['amenity'='fast_food']@['amenity'='cafe']@['amenity'='ice_cream']@[shop]@[office]@[craft]@[sport]@[amenity=toilets]@[amenity=drinking_water]@['amenity'='pub']@['amenity'='bar']@['amenity'='nightclub']@['amenity'='biergarten']@['amenity'='stripclub']@[amenity='pharmacy']@[amenity='fuel']@['amenity'='bank']@['amenity'='atm']@['amenity'='cinema']@['amenity'='theatre']@['amenity'='college']@['amenity'='library']@['amenity'='university']@['amenity'='kindergarten']@[tourism]@['amenity'='clinic']@['amenity'='hospital']@['amenity'='dentist']@['amenity'='doctors']@['amenity'='veterinary']@['amenity'='social_facility']@['emergency'='ambulance_station']@['emergency'='defibrillator']" data-tag-type="main"><?php echo PANEL_ALL;?></a></li>
                <li class="divider"></li>                
                <li><a id="craft"><?php echo PANEL_CRAFT;?></a></li>
                <li><a id="health"><?php echo PANEL_HEALTH;?></a></li>
                <li><a id="eat"  data-tag-pair="['amenity'='restaurant']@['amenity'='fast_food']@['amenity'='cafe']@['amenity'='ice_cream']" data-tag-type="main"><?php echo PANEL_EAT;?></a></li>
                <li><a id="money"><?php echo PANEL_MONEY;?></a></li>
                <li><a id="need"><?php echo PANEL_NEED;?></a></li>
                <li><a id="office"><?php echo PANEL_OFFICE;?></a></li>
                <li><a id="party"><?php echo PANEL_PARTY;?></a></li>
                <li><a id="exercise"><?php echo PANEL_EXERCISE;?></a></li>
                <li><a id="education"><?php echo PANEL_EDUCATION;?></a></li>
                <li><a id="tourism"><?php echo PANEL_TOURISM;?></a></li>
                <li><a id="buy"><?php echo PANEL_BUY;?></a></li>
                <li><a id="culture" data-tag-pair="['amenity'='cinema']@['amenity'='theatre']" data-tag-type="main"><?php echo PANEL_CULTURE;?></a></li>
              </ul>
            </li>

            <li class="dropdown  btn-group btn-group-own  visible-eat">
              <a class="dropdown-toggle btn-select" id="cuisine" data-toggle="dropdown" data-arrow><?php echo PANEL_CUISINE;?><span class="caret"></span></a>
              <ul class="dropdown-menu select-one dropdown-menu-long tag-parent" data-tag-key="cuisine" data-tag-char="~">
                <li><a id="c-all" data-tag-pair="$$"><?php echo PANEL_CUISINE_ALL;?></a></li>
                <li class="divider"></li>
                <li><a id="bagel"><?php echo PANEL_CUISINE_BAGEL;?></a></li>	
                <li><a id="barbecue"><?php echo PANEL_CUISINE_BARBECUE;?></a></li> 		
                <li><a id="bougatsa"><?php echo PANEL_CUISINE_BOUGATSA;?></a></li>	
                <li><a id="burger"><?php echo PANEL_CUISINE_BURGER;?></a></li> 		
                <li><a id="cake"><?php echo PANEL_CUISINE_CAKE;?></a></li>	
                <li><a id="chicken"><?php echo PANEL_CUISINE_CHICKEN;?></a></li>
                <li><a id="coffee_shop" data-tag-exclude="['amenity'='cafe']"><?php echo PANEL_CUISINE_CAFFEE_SHOP;?></a></li> 		
                <li><a id="crepe"><?php echo PANEL_CUISINE_CREPE;?></a></li>		
                <li><a id="couscous"><?php echo PANEL_CUISINE_COUSCOUS;?></a></li>		
                <li><a id="curry"><?php echo PANEL_CUISINE_CURRY;?></a></li>		
                <li><a id="donut"><?php echo PANEL_CUISINE_DONUT;?></a></li>
                <li><a id="doughnut"><?php echo PANEL_CUISINE_DOUGHNUT;?></a></li>
                <li><a id="empanada"><?php echo PANEL_CUISINE_EMPANADA;?></a></li>
                <li><a id="fish_and_chips"><?php echo PANEL_CUISINE_FISH_AND_CHIPS;?></a></li>	
                <li><a id="fried_food"><?php echo PANEL_CUISINE_FRIED_FOOD;?></a></li>	
                <li><a id="friture"><?php echo PANEL_CUISINE_FRITURE;?></a></li> 		
                <li><a id="ice_cream" data-tag-exclude="['amenity'='ice_cream']"><?php echo PANEL_CUISINE_ICE_CREAM;?></a></li>	
                <li><a id="kebab"><?php echo PANEL_CUISINE_KEBAB;?></a></li>
                <li><a id="mediterranean"><?php echo PANEL_CUISINE_MEDITERRANEAN;?></a></li>
                <li><a id="noodle"><?php echo PANEL_CUISINE_NOODLE;?></a></li>		
                <li><a id="pancake"><?php echo PANEL_CUISINE_PANCAKE;?></a></li>	
                <li><a id="pasta"><?php echo PANEL_CUISINE_PASTA;?></a></li> 
                <li><a id="pie"><?php echo PANEL_CUISINE_PIE;?></a></li>
                <li><a id="pizza"><?php echo PANEL_CUISINE_PIZZA;?></a></li>
                <li><a id="regional"><?php echo PANEL_CUISINE_REGIONAL;?></a></li>
                <li><a id="sandwich"><?php echo PANEL_CUISINE_SANDWICH;?></a></li>
                <li><a id="sausage"><?php echo PANEL_CUISINE_SAUSAGE;?></a></li>
                <li><a id="savory_pancakes"><?php echo PANEL_CUISINE_SAVORY_PANCAKES;?></a></li>
                <li><a id="seafood"><?php echo PANEL_CUISINE_SEAFOOD;?></a></li>
                <li><a id="steak_house"><?php echo PANEL_CUISINE_STEAK_HOUSE;?></a></li>
                <li><a id="sushi"><?php echo PANEL_CUISINE_SUSHI;?></a></li>
                <li class="divider"></li>
                <li><a id="african"><?php echo PANEL_CUISINE_AFRICAN;?></a></li>
                <li><a id="american"><?php echo PANEL_CUISINE_AMERICAN;?></a></li>
                <li><a id="arab"><?php echo PANEL_CUISINE_ARAB;?></a></li>
                <li><a id="argentinian"><?php echo PANEL_CUISINE_ARGENTINIAN;?></a></li>
                <li><a id="asian"><?php echo PANEL_CUISINE_ASIAN;?></a></li>
                <li><a id="asian_all" data-tag-pair="[cuisine~'noodle|cantonese|chinese|asian|japanese|sushi|savory_pancakes|kyo_ryouri|okinawa_ryori|korean|thai|vietnamese']"><?php echo PANEL_CUISINE_ASIAN_ALL;?></a></li>
                <li><a id="baiana"><?php echo PANEL_CUISINE_BAIANA;?></a></li>
                <li><a id="balkan"><?php echo PANEL_CUISINE_BALKAN;?></a></li>
                <li><a id="basque"><?php echo PANEL_CUISINE_BASQUE;?></a></li>
                <li><a id="bavarian"><?php echo PANEL_CUISINE_BAVARIAN;?></a></li>
                <li><a id="brazilian"><?php echo PANEL_CUISINE_BRAZILIAN;?></a></li>
                <li><a id="cantonese"><?php echo PANEL_CUISINE_CANTONESE;?></a></li>
                <li><a id="capixaba"><?php echo PANEL_CUISINE_CAPIXABA;?></a></li>
                <li><a id="caribbean"><?php echo PANEL_CUISINE_CARIBBEAN;?></a></li>
                <li><a id="chinese"><?php echo PANEL_CUISINE_CHINESE;?></a></li>
                <li><a id="croatian"><?php echo PANEL_CUISINE_CROATIAN;?></a></li>
                <li><a id="czech"><?php echo PANEL_CUISINE_CZECH;?></a></li>
                <li><a id="french"><?php echo PANEL_CUISINE_FRENCH;?></a></li>
                <li><a id="german"><?php echo PANEL_CUISINE_GERMAN;?></a></li>
                <li><a id="greek"><?php echo PANEL_CUISINE_GREEK;?></a></li>
                <li><a id="gaucho"><?php echo PANEL_CUISINE_GAUCHO;?></a></li>
                <li><a id="hunan"><?php echo PANEL_CUISINE_HUNAN;?></a></li>
                <li><a id="hungarian"><?php echo PANEL_CUISINE_HUNGARIAN;?></a></li>
                <li><a id="indian"><?php echo PANEL_CUISINE_INDIAN;?></a></li>
                <li><a id="international"><?php echo PANEL_CUISINE_INTERNATIONAL;?></a></li>
                <li><a id="iranian"><?php echo PANEL_CUISINE_IRANIAN;?></a></li>
                <li><a id="italian"><?php echo PANEL_CUISINE_ITALIAN;?></a></li>
                <li><a id="japanese"><?php echo PANEL_CUISINE_JAPANESE;?></a></li>
                <li><a id="kyo_ryouri"><?php echo PANEL_CUISINE_KYO_RYOURI;?></a></li>
                <li><a id="korean"><?php echo PANEL_CUISINE_KOREAN;?></a></li>
                <li><a id="latin_american"><?php echo PANEL_CUISINE_LATIN_AMERICAN;?></a></li>
                <li><a id="lebanese"><?php echo PANEL_CUISINE_LEBANESE;?></a></li>
                <li><a id="mexican"><?php echo PANEL_CUISINE_MEXICAN;?></a></li>
                <li><a id="mineira"><?php echo PANEL_CUISINE_MINEIRA;?></a></li>
                <li><a id="okinawa_ryori"><?php echo PANEL_CUISINE_OKINAWA_RYORI;?></a></li>
                <li><a id="peruvian"><?php echo PANEL_CUISINE_PERUVIAN;?></a></li>
                <li><a id="polish"><?php echo PANEL_CUISINE_POLISH;?></a></li>
                <li><a id="portuguese"><?php echo PANEL_CUISINE_PORTUGUESE;?></a></li>
                <li><a id="russian"><?php echo PANEL_CUISINE_RUSSIAN;?></a></li>
                <li><a id="shandong"><?php echo PANEL_CUISINE_SHANDONG;?></a></li>
                <li><a id="sichuan"><?php echo PANEL_CUISINE_SICHUAN;?></a></li>
                <li><a id="spanish"><?php echo PANEL_CUISINE_SPANISH;?></a></li>
                <li><a id="thai"><?php echo PANEL_CUISINE_THAI;?></a></li>
                <li><a id="turkish"><?php echo PANEL_CUISINE_TURKISH;?></a></li>
              </ul>
            </li>

            <li class="dropdown  btn-group btn-group-own  visible-money">
              <a class="dropdown-toggle btn-select tag-default" id="mon" data-toggle="dropdown" data-default-id="place_all" data-arrow><?php echo PANEL_PLACE_ALL;?><span class="caret"></span></a>
              <ul class="dropdown-menu select-one dropdown-menu-long tag-parent">
                <li><a id="place_all" data-tag-pair="['amenity'='bank']@['amenity'='atm']" data-tag-type="main"><?php echo PANEL_PLACE_ALL;?></a></li>
                <li class="divider"></li>
                <li><a id="bank" data-tag-pair="['amenity'='bank']" data-tag-type="main"><?php echo PANEL_PLACE_BANK;?></a></li>
                <li><a id="atm" data-tag-pair="['amenity'='atm']@[atm=yes]" data-tag-type="main"><?php echo PANEL_PLACE_ATM;?></a></li>
              </ul>
            </li>

            <li class="dropdown  btn-group btn-group-own visible-money">
              <a class="dropdown-toggle btn-select" id="currency" data-toggle="dropdown" ><?php echo PANEL_CURRENCY;?><span class="caret"></span></a>
              <ul class="dropdown-menu dropdown-always-on  tag-parent">
                <li class="dropdown-header"><?php echo PANEL_CURRENCY_HEADER;?></li>
                <li class="select-multi-state"><a id="currency_eur" data-tag-pair-s1="['currency:EUR'~'yes|only']"><span style="display:none;" class="glyphicon glyphicon-ok state1"></span>EUR</a></li>
                <li class="select-multi-state"><a id="currency_pln" data-tag-pair-s1="['currency:PLN'~'yes|only']"><span style="display:none;" class="glyphicon glyphicon-ok state1"></span>PLN</a></li>
                <li class="select-multi-state"><a id="currency_rub" data-tag-pair-s1="['currency:RUB'~'yes|only']"><span style="display:none;" class="glyphicon glyphicon-ok state1"></span>RUB</a></li>
                <li class="select-multi-state"><a id="currency_usd" data-tag-pair-s1="['currency:USD'~'yes|only']"><span style="display:none;" class="glyphicon glyphicon-ok state1"></span>USD</a></li>
                <li class="divider"></li>
                <li class="dropdown-header"><?php echo PANEL_CURRENCY_CRYPTO;?></li>
                <li class="select-multi-state"><a id="currency_xbt" data-tag-pair-s1="['currency:XBT'~'yes|only']"><span style="display:none;" class="glyphicon glyphicon-ok state1"></span>XBT (BTC)</a></li>
              </ul>
            </li>


            <li class="dropdown  btn-group btn-group-own  visible-eat">
              <a class="dropdown-toggle btn-select" id="diet" data-toggle="dropdown" ><?php echo PANEL_DIET;?><span class="caret"></span></a>
              <ul class="dropdown-menu dropdown-always-on  tag-parent">
                <li class="dropdown-header"><?php echo PANEL_DIET_HEADER;?></li>
                <li class="select-multi-state">
<a id="pescetarian" data-tag-pair-s1="['diet:vegetarian'~'yes|only']@['diet:ovo_vegetarian'~'yes|only']@['diet:lacto_vegetarian'~'yes|only']@['diet:vegan'~'yes|only']@['diet:fruitarian'~'yes|only']" data-tag-pair-s2="['diet:pescetarian'='only']">
<span style="display:none;" class="glyphicon glyphicon-ok state1"></span><span style="display:none;" class="glyphicon glyphicon-ok-sign state2"></span><?php echo PANEL_DIET_PESCETARIAN;?></a></li>
                <li class="select-multi-state">
<a id="vegetarian" data-tag-pair-s1="['diet:vegetarian'~'yes|only']@['diet:ovo_vegetarian'~'yes|only']@['diet:lacto_vegetarian'~'yes|only']@['diet:vegan'~'yes|only']@['diet:fruitarian'~'yes|only']" data-tag-pair-s2="['diet:vegetarian'='only']">
<span style="display:none;" class="glyphicon glyphicon-ok state1"></span><span style="display:none;" class="glyphicon glyphicon-ok-sign state2"></span><?php echo PANEL_DIET_VEGETARIAN;?></a></li>
                <li class="select-multi-state">
<a id="lacto_vegetarian" data-tag-pair-s1="['diet:lacto_vegetarian'~'yes|only']@['diet:vegan'~'yes|only']@['diet:fruitarian'~'yes|only']" data-tag-pair-s2="['diet:lacto_vegetarian'='only']">
<span style="display:none;" class="glyphicon glyphicon-ok state1"></span><span style="display:none;" class="glyphicon glyphicon-ok-sign state2"></span><?php echo PANEL_DIET_LACTO_VEGETARIAN;?></a></li>
				<li class="select-multi-state">
<a id="ovo_vegetarian" data-tag-pair-s1="['diet:ovo_vegetarian'~'yes|only']@['diet:vegan'~'yes|only']@['diet:fruitarian'~'yes|only']" data-tag-pair-s2="['diet:ovo_vegetarian'='only']">
<span style="display:none;" class="glyphicon glyphicon-ok state1"></span><span style="display:none;" class="glyphicon glyphicon-ok-sign state2"></span><?php echo PANEL_DIET_OVO_VEGETARIAN;?></a></li>
                <li class="select-multi-state">
<a id="vegan" data-tag-pair-s1="['diet:vegan'~'yes|only']@['diet:fruitarian'~'yes|only']" data-tag-pair-s2="['diet:vegan'='only']">
<span style="display:none;" class="glyphicon glyphicon-ok state1"></span><span style="display:none;" class="glyphicon glyphicon-ok-sign state2"></span><?php echo PANEL_DIET_VEGAN;?></a></li>
                <li class="select-multi-state">
<a id="fruitarian" data-tag-pair-s1="['diet:fruitarian'~'yes|only']" data-tag-pair-s2="['diet:fruitarian'='only']">
<span style="display:none;" class="glyphicon glyphicon-ok state1"></span><span style="display:none;" class="glyphicon glyphicon-ok-sign state2"></span><?php echo PANEL_DIET_FRUITARIAN;?></a></li>
                <li class="select-multi-state">
<a id="raw" data-tag-pair-s1="['diet:raw'~'yes|only']" data-tag-pair-s2="['diet:raw'='only']">
<span style="display:none;" class="glyphicon glyphicon-ok state1"></span><span style="display:none;" class="glyphicon glyphicon-ok-sign state2"></span><?php echo PANEL_DIET_RAW;?></a></li>
                <li class="select-multi-state">
<a id="gluten_free" data-tag-pair-s1="['diet:gluten_free'~'yes|only']" data-tag-pair-s2="['diet:gluten_free'='only']">
<span style="display:none;" class="glyphicon glyphicon-ok state1"></span><span style="display:none;" class="glyphicon glyphicon-ok-sign state2"></span><?php echo PANEL_DIET_GLUTEN_FREE;?></a></li>
                <li class="select-multi-state">
<a id="dairy_free" data-tag-pair-s1="['diet:dairy_free'~'yes|only']" data-tag-pair-s2="['diet:dairy_free'='only']">
<span style="display:none;" class="glyphicon glyphicon-ok state1"></span><span style="display:none;" class="glyphicon glyphicon-ok-sign state2"></span><?php echo PANEL_DIET_DAIRY_FREE;?></a></li>
                <li class="select-multi-state">
<a id="lactose_free" data-tag-pair-s1="['diet:lactose_free'~'yes|only']" data-tag-pair-s2="['diet:lactose_free'='only']">
<span style="display:none;" class="glyphicon glyphicon-ok state1"></span><span style="display:none;" class="glyphicon glyphicon-ok-sign state2"></span><?php echo PANEL_DIET_LACTOSE_FREE;?></a></li>
                <li class="select-multi-state">
<a id="halal" data-tag-pair-s1="['diet:halal'~'yes|only']" data-tag-pair-s2="['diet:halal'='only']">
<span style="display:none;" class="glyphicon glyphicon-ok state1"></span><span style="display:none;" class="glyphicon glyphicon-ok-sign state2"></span><?php echo PANEL_DIET_HALAL;?></a></li>
              </ul>
            </li>

            <li style="display:none;" class="dropdown  btn-group btn-group-own  visible-party">
              <a class="dropdown-toggle btn-select" id="where" data-toggle="dropdown" ><?php echo PANEL_WHERE;?><span class="caret"></span></a>
              <ul class="dropdown-menu dropdown-always-on  tag-parent">
                <li class="dropdown-header"><?php echo PANEL_WHERE_HEADER;?></li>
                <li class="select-multi-state"><a id="pub" data-tag-pair-s0="['amenity'='pub']" data-tag-type="main"><span class="glyphicon glyphicon-ok state0"></span><span style="display:none;" class="glyphicon glyphicon-remove state1"></span><?php echo PANEL_WHERE_PUB;?></a></li> 
                <li class="select-multi-state"><a id="bar"  data-tag-pair-s0="['amenity'='bar']" data-tag-type="main"><span class="glyphicon glyphicon-ok state0"></span><span style="display:none;" class="glyphicon glyphicon-remove state1"></span><?php echo PANEL_WHERE_BAR;?></a></li>		
                <li class="select-multi-state"><a id="nightclub" data-tag-pair-s0="['amenity'='nightclub']" data-tag-type="main"><span class="glyphicon glyphicon-ok state0"></span><span style="display:none;" class="glyphicon glyphicon-remove state1"></span><?php echo PANEL_WHERE_NIGHTCLUB;?></a></li>
                <li class="select-multi-state"><a id="biergarten" data-tag-pair-s0="['amenity'='biergarten']" data-tag-type="main"><span class="glyphicon glyphicon-ok state0"></span><span style="display:none;" class="glyphicon glyphicon-remove state1"></span><?php echo PANEL_WHERE_BIERGARTEN;?></a></li>
                <li class="select-multi-state"><a id="stripclub" data-tag-pair-s0="['amenity'='stripclub']" data-tag-type="main"><span class="glyphicon glyphicon-ok state0"></span><span style="display:none;" class="glyphicon glyphicon-remove state1"></span><?php echo PANEL_WHERE_STRIPCLUB;?></a></li>
              </ul>
            </li>

            <li style="display:none;" class="dropdown  btn-group btn-group-own visible-party">
              <a class="dropdown-toggle btn-select" id="beer" data-toggle="dropdown" ><?php echo PANEL_BEER;?><span class="caret"></span></a>
              <ul class="dropdown-menu dropdown-always-on  tag-parent">
                <li class="dropdown-header"><?php echo PANEL_BEER_HEADER;?></li>
                <li class="select-multi-state"><a id="microbrewery" data-tag-pair-s1="['microbrewery'='yes']"><span style="display:none;" class="glyphicon glyphicon-ok state1"></span><?php echo PANEL_BEER_MICROBREWERY;?></a></li>
                <li class="select-multi-state"><a id="real_cider" data-tag-pair-s1="['real_cider'='yes']"><span style="display:none;" class="glyphicon glyphicon-ok state1"></span><?php echo PANEL_BEER_REAL_CIDER;?></a></li>
                <li class="select-multi-state"><a id="real_ale" data-tag-pair-s1="['real_ale'='yes']"><span style="display:none;" class="glyphicon glyphicon-ok state1"></span><?php echo PANEL_BEER_REAL_ALE;?></a></li>
                <li>
                  <input type="text" data-tag-key="brewery" data-tag-value='@' data-tag-char="~" class="form-control select-text" style="height:30px" placeholder="<?php echo PANEL_BEER_BREWERY_PLACEHOLDER;?>" id="brewery">
                </li>
              </ul>
            </li>

            <li style="display:none;" class="dropdown  btn-group btn-group-own  visible-health">
              <a class="dropdown-toggle btn-select" id="health-list" data-toggle="dropdown" ><?php echo PANEL_HEALTH_LIST;?><span class="caret"></span></a>
              <ul class="dropdown-menu dropdown-always-on  tag-parent">
                <li class="dropdown-header"><?php echo PANEL_HEALTH_LIST_HEADER;?></li>
                <li class="select-multi-state"><a id="hclinic" data-tag-pair-s0="['amenity'='clinic']" data-tag-type="main"><span class="glyphicon glyphicon-ok state0"></span><span style="display:none;" class="glyphicon glyphicon-remove state1"></span><?php echo PANEL_HEALTH_CLINIC;?></a></li>
                <li class="select-multi-state"><a id="hhospital" data-tag-pair-s0="['amenity'='hospital']" data-tag-type="main"><span class="glyphicon glyphicon-ok state0"></span><span style="display:none;" class="glyphicon glyphicon-remove state1"></span><?php echo PANEL_HEALTH_HOSPITAL;?></a></li>
                <li class="select-multi-state"><a id="hdentist" data-tag-pair-s0="['amenity'='dentist']" data-tag-type="main"><span class="glyphicon glyphicon-ok state0"></span><span style="display:none;" class="glyphicon glyphicon-remove state1"></span><?php echo PANEL_HEALTH_DENTIST;?></a></li>
                <li class="select-multi-state"><a id="hdoctors" data-tag-pair-s0="['amenity'='doctors']" data-tag-type="main"><span class="glyphicon glyphicon-ok state0"></span><span style="display:none;" class="glyphicon glyphicon-remove state1"></span><?php echo PANEL_HEALTH_DOCTORS;?></a></li>
                <li class="select-multi-state"><a id="hpharmacy" data-tag-pair-s0="['amenity'='pharmacy']" data-tag-type="main"><span class="glyphicon glyphicon-ok state0"></span><span style="display:none;" class="glyphicon glyphicon-remove state1"></span><?php echo PANEL_HEALTH_PHARMACY;?></a></li>
                <li class="select-multi-state"><a id="hvet" data-tag-pair-s0="['amenity'='veterinary']" data-tag-type="main"><span class="glyphicon glyphicon-ok state0"></span><span style="display:none;" class="glyphicon glyphicon-remove state1"></span><?php echo PANEL_HEALTH_VETERINARY;?></a></li>
                <li class="select-multi-state"><a id="hsocial" data-tag-pair-s0="['amenity'='social_facility']" data-tag-type="main"><span class="glyphicon glyphicon-ok state0"></span><span style="display:none;" class="glyphicon glyphicon-remove state1"></span><?php echo PANEL_HEALTH_SOCIAL_FACILITY;?></a></li>
                <li class="select-multi-state"><a id="hambulance" data-tag-pair-s0="['emergency'='ambulance_station']" data-tag-type="main"><span class="glyphicon glyphicon-ok state0"></span><span style="display:none;" class="glyphicon glyphicon-remove state1"></span><?php echo PANEL_HEALTH_AMBULANCE_STATION;?></a></li>
                <li class="select-multi-state"><a id="hdefibrillator" data-tag-pair-s0="['emergency'='defibrillator']" data-tag-type="main"><span class="glyphicon glyphicon-ok state0"></span><span style="display:none;" class="glyphicon glyphicon-remove state1"></span><?php echo PANEL_HEALTH_DEFIBRILLATOR;?></a></li>
              </ul>
            </li>

            <li style="display:none;" class="dropdown  btn-group btn-group-own  visible-office">
              <a class="dropdown-toggle btn-select tag-default" id="office" data-toggle="dropdown" data-default-id="office_all" data-arrow><?php echo PANEL_OFFICE_LIST;?><span class="caret"></span></a>
              <ul class="dropdown-menu select-one dropdown-menu-long tag-parent">
                <li><a id="office_all" data-tag-pair="[office]" data-tag-type="main"><?php echo PANEL_OFFICE_ALL;?></a></li>
                <li class="divider"></li>
                <li><a id="office_accountant" data-tag-pair="[office=accountant]" data-tag-type="main"><?php echo PANEL_OFFICE_ACCOUNTANT;?></a></li>
                <li><a id="office_administrative" data-tag-pair="[office=administrative]" data-tag-type="main"><?php echo PANEL_OFFICE_ADMINISTRATIVE;?></a></li>
                <li><a id="office_architect" data-tag-pair="[office=architect]" data-tag-type="main"><?php echo PANEL_OFFICE_ARCHITECT;?></a></li>
                <li><a id="office_association" data-tag-pair="[office=association]" data-tag-type="main"><?php echo PANEL_OFFICE_ASSOCIATION;?></a></li>
                <li><a id="office_lawyer" data-tag-pair="[office=lawyer]" data-tag-type="main"><?php echo PANEL_OFFICE_LAWYER;?></a></li>
                <li><a id="office_notary" data-tag-pair="[office=notary]" data-tag-type="main"><?php echo PANEL_OFFICE_NOTARY;?></a></li>
              </ul>
            </li>

            <li style="display:none;" class="dropdown  btn-group btn-group-own  visible-craft">
              <a class="dropdown-toggle btn-select tag-default" id="craft" data-toggle="dropdown" data-default-id="craft_all" data-arrow><?php echo PANEL_CRAFT_LIST;?><span class="caret"></span></a>
              <ul class="dropdown-menu select-one dropdown-menu-long tag-parent">
                <li><a id="craft_all" data-tag-pair="[craft]" data-tag-type="main"><?php echo PANEL_CRAFT_ALL;?></a></li>
                <li class="divider"></li>
                <li><a id="craft_carpenter" data-tag-pair="[craft=carpenter]" data-tag-type="main"><?php echo PANEL_CRAFT_CARPENTER;?></a></li>
                <li><a id="craft_clockmaker" data-tag-pair="[craft=clockmaker]" data-tag-type="main"><?php echo PANEL_CRAFT_CLOCKMAKER;?></a></li>
                <li><a id="craft_glaziery" data-tag-pair="[craft=glaziery]" data-tag-type="main"><?php echo PANEL_CRAFT_GLAZIERY;?></a></li>
                <li><a id="craft_photographer" data-tag-pair="[craft=photographer]" data-tag-type="main"><?php echo PANEL_CRAFT_PHOTOGRAPHER;?></a></li>

              </ul>
            </li>

            <li style="display:none;" class="dropdown  btn-group btn-group-own  visible-need">
              <a class="dropdown-toggle btn-select" id="need" data-toggle="dropdown" ><?php echo PANEL_NEED_LIST;?><span class="caret"></span></a>
              <ul class="dropdown-menu dropdown-always-on  tag-parent">
                <li class="dropdown-header"><?php echo PANEL_NEED_HEADER;?></li>
                <li class="select-multi-state"><a id="toilets" data-tag-pair-s0="['amenity'='toilets']" data-tag-type="main"><span class="glyphicon glyphicon-ok state0"></span><span style="display:none;" class="glyphicon glyphicon-remove state1"></span><?php echo PANEL_NEED_TOILETS;?></a></li>
                <li class="select-multi-state"><a id="drinking_water" data-tag-pair-s0="['amenity'='drinking_water']" data-tag-type="main"><span class="glyphicon glyphicon-ok state0"></span><span style="display:none;" class="glyphicon glyphicon-remove state1"></span><?php echo PANEL_NEED_DRINKING_WATER;?></a></li>
                <li class="select-multi-state"><a id="shelter" data-tag-pair-s0="['amenity'='shelter']" data-tag-type="main"><span class="glyphicon glyphicon-ok state0"></span><span style="display:none;" class="glyphicon glyphicon-remove state1"></span><?php echo PANEL_NEED_SHELTER;?></a></li>
              </ul>
            </li>

            <li class="dropdown  btn-group btn-group-own  visible-party" style="display:none">
              <a class="dropdown-toggle btn-select" id="access" data-toggle="dropdown" ><?php echo PANEL_ACCESS;?><span class="caret"></span></a>
              <ul class="dropdown-menu dropdown-always-on  tag-parent">
                <li class="dropdown-header"><?php echo PANEL_ACCESS_HEADER;?></li>
                <li class="select-multi-state"><a id="male" data-tag-pair-s1="['male'~'yes|only']" data-tag-pair-s2="['male'='only']"><span style="display:none;" class="glyphicon glyphicon-ok state1"></span><span style="display:none;" class="glyphicon glyphicon-ok-sign state2"></span><?php echo PANEL_ACCESS_MALE;?></a></li>
                <li class="select-multi-state"><a id="female" data-tag-pair-s1="['female'~'yes|only']" data-tag-pair-s2="['female'='only']"><span style="display:none;" class="glyphicon glyphicon-ok state1"></span><span style="display:none;" class="glyphicon glyphicon-ok-sign state2"></span><?php echo PANEL_ACCESS_FEMALE;?></a></li>
                <li class="select-multi-state"><a id="gay"  data-tag-pair-s1="['gay'~'yes|only|welcome']" data-tag-pair-s2="['gay'='only']"><span style="display:none;" class="glyphicon glyphicon-ok state1"></span><span style="display:none;" class="glyphicon glyphicon-ok-sign state2"></span><?php echo PANEL_ACCESS_GAY;?></a></li>                
              </ul>
            </li>        

            <li style="display:none;" class="dropdown  btn-group btn-group-own  visible-buy">
              <a class="dropdown-toggle btn-select tag-default" id="store" data-toggle="dropdown" data-default-id="store_all" data-arrow><?php echo PANEL_STORE;?><span class="caret"></span></a>
              <ul class="dropdown-menu select-one dropdown-menu-long tag-parent">
                <li><a id="store_all" data-tag-pair="[shop]@[amenity='pharmacy']@[office=travel_agency]@[amenity='fuel']" data-tag-type="main"><?php echo PANEL_STORE_ALL;?></a></li>
                <li class="divider"></li>
                <li><a id="store_alcohol" data-tag-pair="[shop=alcohol]@[shop]['alcohol'='yes']" data-tag-type="main"><?php echo PANEL_STORE_ALCOHOL;?></a></li>
                <li><a id="store_art" data-tag-pair="[shop=art]@[shop=music]" data-tag-type="main"><?php echo PANEL_STORE_ART;?></a></li>
                <li><a id="store_clothes" data-tag-pair="[shop=clothes]@[shop=shoes]@[shop=second_hand]" data-tag-type="main"><?php echo PANEL_STORE_CLOTHES;?></a></li>
                <li><a id="store_food" data-tag-pair="[shop=supermarket]@[shop=bakery]@[shop=butcher]@[shop=convenience]@[shop=farm]@[shop=greengrocer]@[shop=seafood]@[shop=confectionery]" data-tag-type="main"><?php echo PANEL_STORE_FOOD;?></a></li>
                <li><a id="store_organic" data-tag-pair="[organic=only]" data-tag-type="main"><?php echo PANEL_STORE_ORGANIC; ?></a></li>
                <li><a id="store_electronic" data-tag-pair="[shop='computer']@[shop=mobile_phone]@[shop=electronics]" data-tag-type="main"><?php echo PANEL_STORE_ELECTRONIC;?></a></li>
                <li><a id="store_health" data-tag-pair="[amenity='pharmacy']@[shop=chemist]@[shop=hairdresser]@[shop=beauty]" data-tag-type="main"><?php echo PANEL_STORE_HEALTH_AND_BEAUTY;?></a></li>
                <li><a id="store_transport" data-tag-pair="[shop=car]@[shop=bicycle]@[shop=motorcycle]@[shop=tyres]@[amenity='fuel']" data-tag-type="main"><?php echo PANEL_STORE_TRANSPORT;?></a></li>
                <li><a id="store_travel" data-tag-pair="[shop=travel_agency]@[office=travel_agency]" data-tag-type="main"><?php echo PANEL_STORE_TRAVEL;?></a></li>
              </ul>
            </li>

            <li style="display:none;" class="dropdown  btn-group btn-group-own  visible-exercise">
              <a class="dropdown-toggle btn-select" id="exercise_where" data-toggle="dropdown" ><?php echo PANEL_WHERE;?><span class="caret"></span></a>
              <ul class="dropdown-menu dropdown-always-on  tag-parent">
                <li class="dropdown-header"><?php echo PANEL_WHERE_HEADER;?></li>
                <li class="select-multi-state"><a id="sport_centre" data-tag-pair-s0="['leisure'='sports_centre']" data-tag-type="main"><span class="glyphicon glyphicon-ok state0"></span><span style="display:none;" class="glyphicon glyphicon-remove state1"></span><?php echo PANEL_WHERE_SPORT_CENTRE;?></a></li> 
                <li class="select-multi-state"><a id="pitch"  data-tag-pair-s0="['leisure'='pitch']" data-tag-type="main"><span class="glyphicon glyphicon-ok state0"></span><span style="display:none;" class="glyphicon glyphicon-remove state1"></span><?php echo PANEL_WHERE_PITCH;?></a></li>
                <li class="select-multi-state"><a id="stadium"  data-tag-pair-s0="['leisure'='stadium']" data-tag-type="main"><span class="glyphicon glyphicon-ok state0"></span><span style="display:none;" class="glyphicon glyphicon-remove state1"></span><?php echo PANEL_WHERE_STADIUM;?></a></li>		
                <li class="select-multi-state"><a id="swimming_pool" data-tag-pair-s0="['leisure'='swimming_pool']" data-tag-type="main"><span class="glyphicon glyphicon-ok state0"></span><span style="display:none;" class="glyphicon glyphicon-remove state1"></span><?php echo PANEL_WHERE_SWIMMING_POOL;?></a></li>
                <li class="select-multi-state"><a id="track" data-tag-pair-s0="['leisure'='track']" data-tag-type="main"><span class="glyphicon glyphicon-ok state0"></span><span style="display:none;" class="glyphicon glyphicon-remove state1"></span><?php echo PANEL_WHERE_TRACK;?></a></li>
                <li class="select-multi-state"><a id="other_a" data-tag-pair-s0="[sport]" data-tag-type="main"><span class="glyphicon glyphicon-ok state0"></span><span style="display:none;" class="glyphicon glyphicon-remove state1"></span><?php echo PANEL_WHERE_OTHER;?></a></li>
              </ul>
            </li>

            <li style="display:none;" class="dropdown  btn-group btn-group-own  visible-exercise">
              <a class="dropdown-toggle btn-select" id="sport" data-toggle="dropdown" data-arrow><?php echo PANEL_SPORT;?><span class="caret"></span></a>
              <ul class="dropdown-menu select-one dropdown-menu-long tag-parent" data-tag-key="sport" data-tag-char="~">
                <li><a id="sport-all" data-tag-pair="$$"><?php echo PANEL_SPORT_ALL;?></a></li>
                <li class="divider"></li>	
                <li><a id="9pin"><?php echo PANEL_SPORT_9PIN;?></a></li>
                <li><a id="10pin"><?php echo PANEL_SPORT_10PIN;?></a></li>
                <li><a id="american_football"><?php echo PANEL_SPORT_AMERICAN_FOOTBALL;?></a></li>
                <li><a id="aikido"><?php echo PANEL_SPORT_AIKIDO;?></a></li>
                <li><a id="archery"><?php echo PANEL_SPORT_ARCHERY;?></a></li>
                <li><a id="athletics"><?php echo PANEL_SPORT_ATHLETICS;?></a></li>
                <li><a id="australian_football"><?php echo PANEL_SPORT_AUSTRALIAN_FOOTBALL;?></a></li>
                <li><a id="base"><?php echo PANEL_SPORT_BASE;?></a></li>
                <li><a id="badminton"><?php echo PANEL_SPORT_BADMINTON;?></a></li>
                <li><a id="baseball"><?php echo PANEL_SPORT_BASEBALL;?></a></li>
                <li><a id="basketball"><?php echo PANEL_SPORT_BASKETBALL;?></a></li>
                <li><a id="beachvolleyball"><?php echo PANEL_SPORT_BEACHVOLLEYBALL;?></a></li>
                <li><a id="bmx"><?php echo PANEL_SPORT_BMX;?></a></li>
                <li><a id="boules"><?php echo PANEL_SPORT_BOULES;?></a></li>
                <li><a id="bowls"><?php echo PANEL_SPORT_BOWLS;?></a></li>
                <li><a id="boxing"><?php echo PANEL_SPORT_BOXING;?></a></li>
                <li><a id="canadian_football"><?php echo PANEL_SPORT_CANADIAN_FOOTBALL;?></a></li>
                <li><a id="canoe"><?php echo PANEL_SPORT_CANOE;?></a></li>
                <li><a id="chess"><?php echo PANEL_SPORT_CHESS;?></a></li>
                <li><a id="climbing"><?php echo PANEL_SPORT_CLIMBING;?></a></li>
                <li><a id="cricket"><?php echo PANEL_SPORT_CRICKET;?></a></li>
                <li><a id="cricket_nets"><?php echo PANEL_SPORT_CRICKET_NETS;?></a></li>
                <li><a id="croquet"><?php echo PANEL_SPORT_CROQUET;?></a></li>
                <li><a id="cycling"><?php echo PANEL_SPORT_CYCLING;?></a></li>
                <li><a id="diving"><?php echo PANEL_SPORT_DIVING;?></a></li>
                <li><a id="dog_racing"><?php echo PANEL_SPORT_DOG_RACING;?></a></li>
                <li><a id="fencing"><?php echo PANEL_SPORT_FENCING;?></a></li>
                <li><a id="equestrian"><?php echo PANEL_SPORT_EQUESTRIAN;?></a></li>
                <li><a id="free_flying"><?php echo PANEL_SPORT_FREE_FLYING;?></a></li>
                <li><a id="gaelic_games"><?php echo PANEL_SPORT_GAELIC_GAMES;?></a></li>
                <li><a id="golf"><?php echo PANEL_SPORT_GOLF;?></a></li>
                <li><a id="gymnastics"><?php echo PANEL_SPORT_GYMNASTICS;?></a></li>
                <li><a id="hockey"><?php echo PANEL_SPORT_HOCKEY;?></a></li>
                <li><a id="horseshoes"><?php echo PANEL_SPORT_HORSESHOES;?></a></li>
                <li><a id="horse_racing"><?php echo PANEL_SPORT_HORSE_RACING;?></a></li>
                <li><a id="ice_stock"><?php echo PANEL_SPORT_ICE_STOCK;?></a></li>
                <li><a id="judo"><?php echo PANEL_SPORT_JUDO;?></a></li>
                <li><a id="karting"><?php echo PANEL_SPORT_KARTING;?></a></li>
                <li><a id="kitesurfing"><?php echo PANEL_SPORT_KITESURFING;?></a></li>
                <li><a id="korfball"><?php echo PANEL_SPORT_KORFBALL;?></a></li>
                <li><a id="motor"><?php echo PANEL_SPORT_MOTOR;?></a></li>
                <li><a id="obstacle_course"><?php echo PANEL_SPORT_OBSTACLE_COURSE;?></a></li>
                <li><a id="orienteering"><?php echo PANEL_SPORT_ORIENTEERING;?></a></li>
                <li><a id="paddle_tennis"><?php echo PANEL_SPORT_PADDLE_TENNIS;?></a></li>
                <li><a id="paragliding"><?php echo PANEL_SPORT_PARAGLIDING;?></a></li>
                <li><a id="pelota"><?php echo PANEL_SPORT_PALOTA;?></a></li>
                <li><a id="racquet"><?php echo PANEL_SPORT_RACQUET;?></a></li>
                <li><a id="rowing"><?php echo PANEL_SPORT_ROWING;?></a></li>
                <li><a id="rugby_league"><?php echo PANEL_SPORT_RUGBY_LEAGUE;?></a></li>
                <li><a id="rugby_union"><?php echo PANEL_SPORT_RUGBY_UNION;?></a></li>
                <li><a id="running"><?php echo PANEL_SPORT_RUNNING;?></a></li>
                <li><a id="scuba_diving"><?php echo PANEL_SPORT_SCUBA_DIVING;?></a></li>
                <li><a id="shooting"><?php echo PANEL_SPORT_SHOOTING;?></a></li>
                <li><a id="skating"><?php echo PANEL_SPORT_SKATING;?></a></li>
                <li><a id="skateboard"><?php echo PANEL_SPORT_SKATEBOARD;?></a></li>
                <li><a id="skiing"><?php echo PANEL_SPORT_SKIING;?></a></li>
                <li><a id="soccer"><?php echo PANEL_SPORT_SOCCER;?></a></li>
                <li><a id="surfing"><?php echo PANEL_SPORT_SURFING;?></a></li>
                <li><a id="swimming"><?php echo PANEL_SPORT_SWIMMING;?></a></li>
                <li><a id="table_tennis"><?php echo PANEL_SPORT_TABLE_TENNIS;?></a></li>
                <li><a id="taekwondo"><?php echo PANEL_SPORT_TEAKWONDO;?></a></li>
                <li><a id="team_handball"><?php echo PANEL_SPORT_TEAM_HANDBALL;?></a></li>
                <li><a id="tennis"><?php echo PANEL_SPORT_TENNIS;?></a></li>
                <li><a id="toboggan"><?php echo PANEL_SPORT_TOBOGGAN;?></a></li>
                <li><a id="volleyball"><?php echo PANEL_SPORT_VOLLEYBALL;?></a></li>
                <li><a id="water_ski"><?php echo PANEL_SPORT_WATER_SKI;?></a></li>
                <li><a id="weightlifting"><?php echo PANEL_SPORT_WEIGHTLIFTING;?></a></li>
                <li><a id="wrestling"><?php echo PANEL_SPORT_WRESTLING;?></a></li>
              </ul>
            </li>


            <li style="display:none;" class="dropdown  btn-group btn-group-own  visible-culture">
              <a class="dropdown-toggle btn-select tag-default" id="theatre_genre" data-toggle="dropdown" data-default-id="theatre_genre_all" data-arrow><?php echo PANEL_THEATRE_GENRE;?><span class="caret"></span></a>
              <ul class="dropdown-menu select-one dropdown-menu-long tag-parent">
                <li><a id="theatre_genre_all"><?php echo PANEL_THEATRE_GENRE_ALL;?></a></li>
                <li class="divider"></li>
                <li><?php echo PANEL_SPEECH_THEATRE;?></li>
                <li><a id="theatre_genre_drama" data-tag-pair="['theatre:genre'~'drama']"><?php echo PANEL_THEATRE_GENRE_DRAMA;?></a></li>
                <li><a id="theatre_genre_comedy" data-tag-pair="['theatre:genre'~'comedy']"><?php echo PANEL_THEATRE_GENRE_COMEDY;?></a></li>
                <li><?php echo PANEL_MUSIC_THEATRE;?></li>
                <li><a id="theatre_genre_opera" data-tag-pair="['theatre:genre'~'opera']"><?php echo PANEL_THEATRE_GENRE_OPERA;?></a></li>
                <li><a id="theatre_genre_musical" data-tag-pair="['theatre:genre'~'musical']"><?php echo PANEL_THEATRE_GENRE_MUSICAL;?></a></li>
                <li><a id="theatre_genre_ballet" data-tag-pair="['theatre:genre'~'ballet']"><?php echo PANEL_THEATRE_GENRE_BALLET;?></a></li>
                <li><a id="theatre_genre_philharmonic" data-tag-pair="['theatre:genre'~'philharmonic']"><?php echo PANEL_THEATRE_GENRE_PHILHARMONIC;?></a></li>
                <li><a id="theatre_genre_chamber_music" data-tag-pair="['theatre:genre'~'chamber_music']"><?php echo PANEL_THEATRE_GENRE_CHAMBER_MUSIC;?></a></li>
                <li><?php echo PANEL_OTHER_THEATRE;?></li>
                <li><a id="theatre_genre_cabaret" data-tag-pair="['theatre:genre'~'cabaret']"><?php echo PANEL_THEATRE_GENRE_CABARET;?></a></li>
                <li><a id="theatre_genre_boulevard" data-tag-pair="['theatre:genre'~'boulevard']"><?php echo PANEL_THEATRE_GENRE_BOULEVARD;?></a></li>
                <li><a id="theatre_genre_circus" data-tag-pair="['theatre:genre'~'circus']"><?php echo PANEL_THEATRE_GENRE_CIRCUS;?></a></li>
                <li><a id="theatre_genre_stand_up_comedy" data-tag-pair="['theatre:genre'~'stand_up_comedy']"><?php echo PANEL_THEATRE_GENRE_STAND_UP_COMEDY;?></a></li>
                <li><a id="theatre_genre_political" data-tag-pair="['theatre:genre'~'political']"><?php echo PANEL_THEATRE_GENRE_POLITICAL;?></a></li>
                <li><a id="theatre_genre_variaté" data-tag-pair="['theatre:genre'~'variaté']"><?php echo PANEL_THEATRE_GENRE_VARIATE;?></a></li>

                <li><?php echo PANEL_PUPPET_THEATRE;?></li>
                <li><a id="theatre_genre_figure" data-tag-pair="['theatre:genre'~'figure']"><?php echo PANEL_THEATRE_GENRE_FIGURE;?></a></li>
                <li><a id="theatre_genre_puppet" data-tag-pair="['theatre:genre'~'puppet']"><?php echo PANEL_THEATRE_GENRE_PUPPET;?></a></li>
                <li><a id="theatre_genre_marionette" data-tag-pair="['theatre:genre'~'marionette']"><?php echo PANEL_THEATRE_GENRE_MARIONETTE;?></a></li>
                <li><a id="theatre_genre_shadow_play" data-tag-pair="['theatre:genre'~'shadow_play']"><?php echo PANEL_THEATRE_GENRE_SHADOW_PLAY;?></a></li>
              </ul>
            </li>

            <li style="display:none;" class="dropdown  btn-group btn-group-own  visible-education">
              <a class="dropdown-toggle btn-select" id="education_type" data-toggle="dropdown" ><?php echo PANEL_EDUCATION_TYPE;?><span class="caret"></span></a>
              <ul class="dropdown-menu dropdown-always-on  tag-parent">
                <li class="dropdown-header"><?php echo PANEL_EDUCATION_TYPE_HEADER;?></li>
                <li class="select-multi-state"><a id="library" data-tag-pair-s0="['amenity'='library']" data-tag-type="main"><span class="glyphicon glyphicon-ok state0"></span><span style="display:none;" class="glyphicon glyphicon-remove state1"></span><?php echo PANEL_EDUCATION_TYPE_LIBRARY;?></a></li> 
                <li class="select-multi-state"><a id="kindergarten"  data-tag-pair-s0="['amenity'='kindergarten']" data-tag-type="main"><span class="glyphicon glyphicon-ok state0"></span><span style="display:none;" class="glyphicon glyphicon-remove state1"></span><?php echo PANEL_EDUCATION_TYPE_KINDERGARTEN;?></a></li>		
                <li class="select-multi-state"><a id="school"  data-tag-pair-s0="['amenity'='school']" data-tag-type="main"><span class="glyphicon glyphicon-ok state0"></span><span style="display:none;" class="glyphicon glyphicon-remove state1"></span><?php echo PANEL_EDUCATION_TYPE_SCHOOL;?></a></li>
                <li class="select-multi-state"><a id="university"  data-tag-pair-s0="['amenity'='university']" data-tag-type="main"><span class="glyphicon glyphicon-ok state0"></span><span style="display:none;" class="glyphicon glyphicon-remove state1"></span><?php echo PANEL_EDUCATION_TYPE_UNIVERSITY;?></a></li>
                <li class="select-multi-state"><a id="college"  data-tag-pair-s0="['amenity'='college']" data-tag-type="main"><span class="glyphicon glyphicon-ok state0"></span><span style="display:none;" class="glyphicon glyphicon-remove state1"></span><?php echo PANEL_EDUCATION_TYPE_COLLEGE;?></a></li>
              </ul>
            </li>

            <li style="display:none;" class="dropdown  btn-group btn-group-own  visible-tourism">
              <a class="dropdown-toggle btn-select tag-default" id="tourism_type" data-toggle="dropdown" data-default-id="tourism_all" data-arrow><?php echo PANEL_TOURISM;?><span class="caret"></span></a>
              <ul class="dropdown-menu select-one dropdown-menu-long tag-parent">
                <li><a id="tourism_all" data-tag-pair="[tourism]" data-tag-type="main"><?php echo PANEL_TOURISM_ALL;?></a></li>
                <li class="divider"></li>
                <li><a id="tourism_attraction" data-tag-pair="[tourism=attraction]@[tourism=viewpoint]@[tourism=museum]@[tourism=theme_park]@[tourism=zoo]" data-tag-type="main"><?php echo PANEL_TOURISM_ATTRACTION;?></a></li>
                <li><a id="tourism_accommodation" data-tag-pair="[tourism=hotel]@[tourism=hostel]@[tourism=guest_house]@[tourism=camp_site]@[tourism=caravan_site]@[tourism=motel]@[tourism=alpine_hut]" data-tag-type="main"><?php echo PANEL_TOURISM_ACCOMMODATION;?></a></li>
                <li><a id="tourism_information" data-tag-pair="[tourism=information]" data-tag-type="main"><?php echo PANEL_TOURISM_INFORMATION;?></a></li>
              </ul>
            </li>

            <li class="dropdown  btn-group btn-group-own">
              <a class="dropdown-toggle btn-select" id="payment" data-toggle="dropdown" ><?php echo PANEL_PAYMENT;?><span class="caret"></span></a>
              <ul class="dropdown-menu dropdown-always-on  tag-parent">
                <li class="dropdown-header"><?php echo PANEL_PAYMENT_HEADER;?></li>
                <li class="select-multi-state"><a id="payment_coins" data-tag-pair-s1="['payment:coins'~'yes|only']"><span style="display:none;" class="glyphicon glyphicon-ok state1"></span><?php echo PANEL_PAYMENT_COINS;?></a></li>
                <li class="select-multi-state"><a id="payment_debit_cards" data-tag-pair-s1="['payment:debit_cards'~'yes|only']"><span style="display:none;" class="glyphicon glyphicon-ok state1"></span><?php echo PANEL_PAYMENT_DEBIT_CARDS;?></a></li>
                <li class="select-multi-state"><a id="payment_credit_cards" data-tag-pair-s1="['payment:credit_cards'~'yes|only']"><span style="display:none;" class="glyphicon glyphicon-ok state1"></span><?php echo PANEL_PAYMENT_CREDIT_CARDS;?></a></li>
                <li class="select-multi-state"><a id="payment_bitcoin" data-tag-pair-s1="['payment:bitcoin'~'yes|only']"><span style="display:none;" class="glyphicon glyphicon-ok state1"></span><?php echo PANEL_PAYMENT_BITCOIN;?></a></li>
                <li class="select-multi-state"><a id="payment_litecoin" data-tag-pair-s1="['payment:litecoin'~'yes|only']"><span style="display:none;" class="glyphicon glyphicon-ok state1"></span><?php echo PANEL_PAYMENT_LITECOIN;?></a></li>
                <li class="select-multi-state"><a id="payment_peercoin" data-tag-pair-s1="['payment:peercoin'~'yes|only']"><span style="display:none;" class="glyphicon glyphicon-ok state1"></span><?php echo PANEL_PAYMENT_PEERCOIN;?></a></li>
              </ul>
            </li>

            <li class="dropdown  btn-group btn-group-own ">
              <a class="dropdown-toggle btn-select" id="other" data-toggle="dropdown" ><?php echo PANEL_OTHER;?><span class="caret"></span></a>
              <ul class="dropdown-menu dropdown-always-on  tag-parent">
                <li class="dropdown-header"><?php echo PANEL_OTHER_HEADER;?></li>
                <li class="visible-eat select-multi-state"><a id="takeaway" data-tag-pair-s1="['takeaway'='yes']"><span style="display:none;" class="glyphicon glyphicon-ok state1"></span><?php echo PANEL_OTHER_TAKE_AWAY;?></a></li>
                <li class="visible-eat select-multi-state"><a id="delivery" data-tag-pair-s1="['delivery'='yes']"><span style="display:none;" class="glyphicon glyphicon-ok state1"></span><?php echo PANEL_OTHER_DELIVERY;?></a></li>
                <li class="select-multi-state"><a id="wheelchair" data-tag-pair-s1="['wheelchair'='yes']"><span style="display:none;" class="glyphicon glyphicon-ok state1"></span><?php echo PANEL_OTHER_WHEELCHAIR;?></a></li>

                <li class="dropdown-header visible-eat visible-party"><?php echo PANEL_OTHER_INTERNET;?></li>
                <li class="dropdown-submenu btn-group-own visible-eat visible-party main">
                  <a tabindex="-1" id="internet" class="dropdown-toggle"><?php echo PANEL_EMPTY;?></a>
                  <ul class="dropdown-menu select-one tag-parent" data-tag-key="internet_access">
                  <li><a id="int_empty" data-tag-pair="$$"><?php echo PANEL_EMPTY;?></a></li>
                  <li><a id="int_no" data-tag-value="no"><?php echo PANEL_NO;?></a></li>
                  <li><a id="int_yes" data-tag-pair='["internet_access"~"wlan|yes|wired|public|terminal"]'><?php echo PANEL_YES;?></a></li>
                  <li><a id="int_free" data-tag-pair="['internet_access:fee'='no']"><?php echo PANEL_FREE;?></a></li>
                  <li><a id="int_wlan" data-tag-value="wlan"><?php echo PANEL_WLAN;?></a></li>
                  </ul>
                </li>

                <li class="dropdown-header visible-eat visible-party"><?php echo PANEL_OTHER_SMOKING;?></li>
                <li class="dropdown-submenu btn-group-own visible-eat visible-party main">
                  <a tabindex="-1" id="smoking" class="dropdown-toggle"><?php echo PANEL_EMPTY;?></a>
                  <ul class="dropdown-menu select-one tag-parent" data-tag-key="smoking">
                  <li><a id="empty" data-tag-pair="$$"><?php echo PANEL_EMPTY;?></a></li>
                  <li><a id="no" data-tag-value="no"><?php echo PANEL_NO;?></a></li>
                  <li><a id="yes" data-tag-pair="['smoking'~'yes|dedicated|isolated|separated']"><?php echo PANEL_YES;?></a></li>
                  <li><a id="dedicated" data-tag-value="dedicated"><?php echo PANEL_DEDICATED;?></a></li>
                  <li><a id="isolated" data-tag-value="isolated"><?php echo PANEL_ISOLATED;?></a></li>
                  <li><a id="separated" data-tag-value="separated"><?php echo PANEL_SEPARATED;?></a></li>
                  </ul>
                </li>

              </ul>
            </li>
         </ul>

         <ul class="nav navbar-nav navbar-right">
          <li class="dropdown language-switcher">
            <a class="dropdown-toggle" data-toggle="dropdown">
              <img class="flag" src="img/flags/<?php echo $_SESSION['lang'];?>.png"/>
            <b class="caret"></b>
            </a>
            <ul class="dropdown-menu flags">
              <li><a href="?lang=de_DE"><img class="flag" src="img/flags/de_DE.png"/>Deutsch</a></li>
              <li><a href="?lang=en_EN"><img class="flag" src="img/flags/en_EN.png"/>English</a></li>
              <li><a href="?lang=fr_FR"><img class="flag" src="img/flags/fr_FR.png"/>Français</a></li>
              <li><a href="?lang=it_IT"><img class="flag" src="img/flags/it_IT.png"/>Italiano</a></li>
              <li><a href="?lang=pl_PL"><img class="flag" src="img/flags/pl_PL.png"/>polski</a></li>
              <li><a href="?lang=ru_RU"><img class="flag" src="img/flags/ru_RU.png"/>Русский</a></li>
              <li><a href="?lang=uk_UA"><img class="flag" src="img/flags/uk_UA.png"/>Українська</a></li>
            </ul>
          </li>
          <li><button onclick="ustaw()" type="button" class="btn btn-primary navbar-btn"><?php echo BUTTON_SET;?></button></li>
        </ul>
      </div><!--/.nav-collapse -->
    </div>
  </div>
  <div style="height: 100%" id="map"></div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">osm24</h4>
        </div>
        <div class="modal-body">
          <img src="//www.openstreetmap.org/assets/osm_logo.png" alt="OpenStreetMap Logo"/><br/>
          <?php echo POPUP_ABOUT_BODY;?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo BUTTON_CLOSE;?></button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="dynModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h3 class="modal-title"></h3>
        </div>
        <div class="modal-body">  
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo BUTTON_CLOSE;?></button>
          <button type="button" class="btn btn-primary callback-btn" data-dismiss="modal"><?php echo BUTTON_ADD;?></button>
        </div>
      </div>
    </div>
  </div>


  <script src="js/own_bootstrap.js"></script>
  <script src="js/query.js"></script>
  <script src="js/poi.js"></script>
  <script src="js/main.js"></script>
  </body>
</html>
