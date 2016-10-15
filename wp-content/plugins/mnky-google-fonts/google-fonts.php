<?php
/* 
Plugin Name: MNKY Google Fonts
Version: v2.8
Description: Google Fonts for theme. 
*/


// Pre-2.6 compatibility
if ( ! defined( 'WP_CONTENT_URL' ) )
      define( 'WP_CONTENT_URL', get_option( 'siteurl' ) . '/wp-content' );
if ( ! defined( 'WP_CONTENT_DIR' ) )
      define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
if ( ! defined( 'WP_PLUGIN_URL' ) )
      define( 'WP_PLUGIN_URL', WP_CONTENT_URL. '/plugins' );
if ( ! defined( 'WP_PLUGIN_DIR' ) )
      define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins' );


if (!class_exists('googlefonts')) {
    class googlefonts {
        //This is where the class variables go, don't forget to use @var to tell what they're for
        /**
        * @var string The options string name for this plugin
        */
        var $optionsName = 'googlefonts_options';
        
        /**
        * @var string $localizationDomain Domain used for localization
        */
        var $localizationDomain = "googlefonts";
        
        /**
        * @var string $pluginurl The path to this plugin
        */ 
        var $thispluginurl = '';
        /**
        * @var string $pluginurlpath The path to this plugin
        */
        var $thispluginpath = '';
            
        /**
        * @var array $options Stores the options for this plugin
        */
        var $options = array();
        
        //Class Functions
        /**
        * PHP 4 Compatible Constructor
        */
        function googlefonts(){$this->__construct();}
        
        /**
        * PHP 5 Constructor
        */        
        function __construct(){

            //"Constants" setup
            $this->thispluginurl = plugins_url(__FILE__).'/';
            $this->thispluginpath = plugin_dir_path(__FILE__).'/';
            
            //Initialize the options
            //This is REQUIRED to initialize the options when the plugin is loaded!
            $this->getOptions();
            
            //Actions        
            add_action("admin_menu", array(&$this,"admin_menu_link"));
            add_action("wp_head", array(&$this,"googlefontsstart"));
            add_action("wp_head", array(&$this,"addgooglefontscss"));            

            /*
            add_action("wp_head", array(&$this,"add_css"));
            add_action('wp_print_scripts', array(&$this, 'add_js'));
            */
            
            //Filters
            /*
            add_filter('the_content', array(&$this, 'filter_content'), 0);
            */
        }
        
        
        
 function googlefontsstart() {

// check to see if site is uses https
$http = (!empty($_SERVER['HTTPS'])) ? "https" : "http";

echo '<!-- Google Fonts -->';


$googlefont1 = $this->options['googlefonts_font1'];
if ($googlefont1!='off' && $googlefont1) {
echo '<link href=\''.$http.'://fonts.googleapis.com/css?family='.$googlefont1.'\' rel=\'stylesheet\' type=\'text/css\' />';
}
$googlefont2 = $this->options['googlefonts_font2'];
if ($googlefont2!='off' && $googlefont2) {
echo '<link href=\''.$http.'://fonts.googleapis.com/css?family='.$googlefont2.'\' rel=\'stylesheet\' type=\'text/css\' />';
}
$googlefont3 = $this->options['googlefonts_font3'];
if ($googlefont3!='off' && $googlefont3) {
echo '<link href=\''.$http.'://fonts.googleapis.com/css?family='.$googlefont3.'\' rel=\'stylesheet\' type=\'text/css\' />';
}

}


function addgooglefontscss() {
	$fullfontname1 = $this->options['googlefonts_font1'];
	$shortfontname1 = explode(":", $fullfontname1);
	$fullfontname2 = $this->options['googlefonts_font2'];
	$shortfontname2 = explode(":", $fullfontname2);
	$fullfontname3 = $this->options['googlefonts_font3'];
	$shortfontname3 = explode(":", $fullfontname3);
	
echo '<style type="text/css" media="screen">';

//Menu #1 Styles:
if ($this->options['googlefonts_font1'] != "off") { echo '#main_menu { font-family: \''; echo $shortfontname1[0];  echo '\', arial, serif; } 
'; }

//Headings #2 Styles:
if ($this->options['googlefonts_font2'] != "off") { echo 'h1, h2, h3, h4, h5, h6, h1 a, h2 a, h3 a, h4 a, h5 a, h6 a, .recent_post-title, .su-service-title, .lb_heading, .su-heading-shell, .su_au_name, .su-pricing-title, .su-pricing-value { font-family: \''; echo $shortfontname2[0]; echo '\', arial, serif; } 
'; }                          

//Body #3 Styles:
if ($this->options['googlefonts_font3'] != "off") { echo 'body { font-family: \''; echo $shortfontname3[0]; echo '\', arial, serif; } 
'; }                          


echo '</style>';
}
    
        /**
        * Retrieves the plugin options from the database.
        * @return array
        */
        function getOptions() {
            //Don't forget to set up the default options
            if (!$theOptions = get_option($this->optionsName)) {
                $theOptions = array(
					'googlefonts1_on_off'=>'unchecked',
					'googlefonts2_on_off'=>'unchecked',
					'googlefonts3_on_off'=>'unchecked',
					'googlefonts_on_off'=>'off'	
			);
                update_option($this->optionsName, $theOptions);
            }
            $this->options = $theOptions;
            
            //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
            //There is no return here, because you should use the $this->options variable!!!
            //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        }
        /**
        * Saves the admin options to the database.
        */
        function saveAdminOptions(){
            return update_option($this->optionsName, $this->options);
        }
        
        /**
        * @desc Adds the options subpanel
        */
          function admin_menu_link() {
           add_menu_page('Google Fonts', 'Google Fonts', 'administrator', 'google_fonts', array(&$this,'admin_options_page'), plugin_dir_url( __FILE__ )."images/icon.png",48);
        }
  
        
        /**
        * Adds settings/options page
        */
        function admin_options_page() { 
            if($_POST['googlefonts_save']){
                if (! wp_verify_nonce($_POST['_wpnonce'], 'googlefonts-update-options') ) die('Whoops! There was a problem with the data you posted. Please go back and try again.'); 

				$this->options['googlefonts_on_off'] = $_POST['googlefonts_on_off'];

				$this->options['googlefonts1_on_off'] = $_POST['googlefonts1_on_off'];
				$this->options['googlefonts2_on_off'] = $_POST['googlefonts2_on_off'];
				$this->options['googlefonts3_on_off'] = $_POST['googlefonts3_on_off'];

				$this->options['googlefonts_font1'] = $_POST['googlefonts_font1'];
				$this->options['googlefonts_font2'] = $_POST['googlefonts_font2'];
				$this->options['googlefonts_font3'] = $_POST['googlefonts_font3'];
                    
                $this->saveAdminOptions();
                
                echo '<div class="updated"><p>Success! Your changes were sucessfully saved!</p></div>';
            }
?>                                   
                <div class="wrap">
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>

		<h1>Custom Google Fonts</h1>
		<p style="margin:20px 0; background: #EFF3F4; border: 1px solid #CEDCF1; color: #33496C; line-height: 1.7; padding: 15px;"><strong>NOTE:</strong> If you want to use Google fonts, please make sure you have <strong>disabled</strong> Cufon fonts first. To do it, go to "Theme Options / Thame Settings / Typography" check "disable cufon" and save changes.</p>
		


                <form method="post" id="googlefonts_options">
                <?php wp_nonce_field('googlefonts-update-options'); ?>

<!-- Font list-->
<!-- https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyBmPRa5TGlBRbUUV-pVPU3GxXRkD4lBtUU&sort=date -->
<?php
	function listgooglefontoptions() { echo '
		<option value="off">NONE (turn off Google font)</option>
		<option value="Abel">Abel </option>
		<option value="Abril Fatface">Abril Fatface</option>
		<option value="Aclonica">Aclonica</option>
		<option value="Acme">Acme</option>
		<option value="Actor">Actor </option>
		<option value="Adamina">Adamina</option>
		<option value="Advent Pro">Advent Pro</option>
		<option value="Advent Pro:100,200,300,400,500,600,700">Advent Pro (plus all weights)</option>
		<option value="Aguafina Script">Aguafina Script</option>
		<option value="Aladin">Aladin</option>
		<option value="Aldrich">Aldrich </option>
		<option value="Alex Brush">Alex Brush</option>
		<option value="Alfa Slab One">Alfa Slab One</option>
		<option value="Alice">Alice </option>
		<option value="Alike Angular">Alike Angular</option>
		<option value="Alike">Alike </option>
		<option value="Allan">Allan</option>
		<option value="Allerta Stencil">Allerta Stencil</option>
		<option value="Allerta">Allerta</option>
		<option value="Allura">Allura</option>
		<option value="Almendra SC">Almendra SC</option>
		<option value="Almendra">Almendra</option>
		<option value="Almendra:400,bold">Almendra:400,bold</option>
		<option value="Amaranth">Amaranth</option>
		<option value="Amarante">Amarante</option>
		<option value="Amatic SC">Amatic SC</option>
		<option value="Amatic SC:400,700">Amatic SC:400,700</option>
		<option value="Amethysta">Amethysta</option>
		<option value="Andada">Andada</option>
		<option value="Andika">Andika </option>
		<option value="Annie Use Your Telescope">Annie Use Your Telescope</option>
		<option value="Anonymous Pro">Anonymous Pro</option>
		<option value="Anonymous Pro:regular,italic,bold,bolditalic">Anonymous Pro (plus italic, bold, and bold italic)</option>
		<option value="Antic Didone">Antic Didone</option>
		<option value="Antic Slab">Antic Slab</option>
		<option value="Antic">Antic</option>
		<option value="Anton">Anton</option>
		<option value="Arapey">Arapey</option>
		<option value="Arapey:400,400italic">Arapey:400,400italic</option>
		<option value="Arbutus">Arbutus</option>
		<option value="Architects Daughter">Architects Daughter</option>
		<option value="Arimo">Arimo</option>
		<option value="Arimo:regular,italic,bold,bolditalic">Arimo (plus italic, bold, and bold italic)</option>
		<option value="Arizonia">Arizonia</option>
		<option value="Armata">Armata</option>
		<option value="Artifika">Artifika</option>
		<option value="Arvo">Arvo</option>
		<option value="Arvo:regular,italic,bold,bolditalic">Arvo (plus italic, bold, and bold italic)</option>
		<option value="Asap">Asap</option>
		<option value="Asap:400,400italic,700,700italic">Asap (plus all weights and italics)</option>
		<option value="Asset">Asset</option>
		<option value="Astloch">Astloch</option>
		<option value="Astloch:regular,bold">Astloch (plus bold)</option>
		<option value="Asul">Asul</option>
		<option value="Asul:400,bold">Asul:400,bold</option>
		<option value="Atomic Age">Atomic Age</option>
		<option value="Aubrey">Aubrey </option>
		<option value="Audiowide">Audiowide</option>
		<option value="Average">Average</option>
		<option value="Averia Gruesa Libre">Averia Gruesa Libre</option>
		<option value="Averia Libre">Averia Libre</option>
		<option value="Averia Libre:300,300italic,400,400italic,700,700italic">Averia Libre (plus all weights and italics)</option>
		<option value="Averia Sans Libre">Averia Sans Libre</option>
		<option value="Averia Sans Libre:300,300italic,400,400italic,700,700italic">Averia Sans Libre (plus all weights and italics)</option>
		<option value="Averia Serif Libre">Averia Serif Libre</option> 
		<option value="Averia Serif Libre:300,300italic,400,400italic,700,700italic">Averia Serif Libre (plus all weights and italics)</option>
		<option value="Bad Script">Bad Script</option>
		<option value="Balthazar">Balthazar</option>
		<option value="Bangers">Bangers</option>
		<option value="Basic">Basic</option>
		<option value="Baumans">Baumans</option>
		<option value="Belgrano">Belgrano</option>
		<option value="Belleza">Belleza</option>
		<option value="Bentham">Bentham</option>
		<option value="Berkshire Swash">Berkshire Swash</option>
		<option value="Bevan">Bevan</option>
		<option value="Bigshot One">Bigshot One</option>
		<option value="Bilbo Swash Caps">Bilbo Swash Caps</option>
		<option value="Bilbo">Bilbo</option>
		<option value="Bitter">Bitter</option>
		<option value="Bitter:400,400italic,700">Bitter:400,400italic,700</option>
		<option value="Black Ops One">Black Ops One </option>
		<option value="Bonbon">Bonbon</option>
		<option value="Boogaloo">Boogaloo</option>
		<option value="Bowlby One SC">Bowlby One SC</option>
		<option value="Bowlby One">Bowlby One</option>
		<option value="Brawler">Brawler </option>
		<option value="Bree Serif">Bree Serif</option>
		<option value="Bubblegum Sans">Bubblegum Sans</option>
		<option value="Buda:light">Buda</option>
		<option value="Buenard">Buenard</option>
		<option value="Buenard:400,bold">Buenard:400,bold</option>
		<option value="Butcherman">Butcherman</option>
		<option value="Butterfly Kids">Butterfly Kids</option>
		<option value="Cabin Condensed">Cabin Condensed</option>
		<option value="Cabin Condensed:400,500,600,700">Cabin Condensed:400,500,600,700</option>
		<option value="Cabin Sketch">Cabin Sketch</option>
		<option value="Cabin Sketch:bold">Cabin Sketch Bold</option>
		<option value="Cabin Sketch:regular,bold">Cabin Sketch:regular,bold</option>
		<option value="Cabin">Cabin</option>
		<option value="Cabin:regular,500,600,bold">Cabin (plus 500, 600, and bold)</option>
		<option value="Caesar Dressing">Caesar Dressing</option>
		<option value="Cagliostro">Cagliostro</option>
		<option value="Calligraffitti">Calligraffitti</option>
		<option value="Cambo">Cambo</option>
		<option value="Candal">Candal</option>
		<option value="Cantarell">Cantarell</option>
		<option value="Cantarell:regular,italic,bold,bolditalic">Cantarell (plus italic, bold, and bold italic)</option>
		<option value="Cantata One">Cantata One</option>
		<option value="Capriola">Capriola</option>
		<option value="Cardo">Cardo</option>
		<option value="Carme">Carme </option>
		<option value="Carter One">Carter One</option>
		<option value="Caudex">Caudex</option>
		<option value="Caudex:regular,italic,bold,bolditalic">Caudex (plus italic, bold, and bold italic)</option>
		<option value="Cedarville Cursive">Cedarville Cursive</option>
		<option value="Ceviche One">Ceviche One</option>
		<option value="Changa One">Changa One</option>
		<option value="Chango">Chango</option>
		<option value="Chau Philomene One">Chau Philomene One</option>
		<option value="Chau Philomene One:400,400italic">Chau Philomene One (plus italic)</option>
		<option value="Chelsea Market">Chelsea Market</option>
		<option value="Cherry Cream Soda">Cherry Cream Soda</option>
		<option value="Chewy">Chewy</option>
		<option value="Chicle">Chicle</option>
		<option value="Chivo">Chivo</option>
		<option value="Chivo:400,900">Chivo (plus bold)</option>
		<option value="Coda">Coda</option>
		<option value="Coda:400,800">Coda:400,800</option>
		<option value="Codystar">Codystar</option>
		<option value="Codystar:300,400">Codystar (plus all weights)</option>
		<option value="Comfortaa">Comfortaa </option>
		<option value="Comfortaa:300,400,700">Comfortaa (plus book and bold) </option>
		<option value="Coming Soon">Coming Soon</option>
		<option value="Concert One">Concert One</option>
		<option value="Condiment">Condiment</option>
		<option value="Contrail One">Contrail One</option>
		<option value="Convergence">Convergence</option>
		<option value="Cookie">Cookie</option>
		<option value="Copse">Copse</option>
		<option value="Corben">Corben</option>
		<option value="Corben:400,bold">Corben:400,bold</option>
		<option value="Corben:bold">Corben Bold</option>
		<option value="Courgette">Courgette</option>
		<option value="Cousine">Cousine</option>
		<option value="Cousine:regular,italic,bold,bolditalic">Cousine (plus italic, bold, and bold italic)</option>
		<option value="Coustard">Coustard </option>
		<option value="Coustard:400,900">Coustard (plus ultra bold) </option>
		<option value="Covered By Your Grace">Covered By Your Grace</option>
		<option value="Crafty Girls">Crafty Girls</option>
		<option value="Creepster">Creepster</option>
		<option value="Crete Round">Crete Round</option>
		<option value="Crete Round:400,400italic">Crete Round:400,400italic</option>
		<option value="Crimson Text">Crimson Text</option>
		<option value="Crushed">Crushed</option>
		<option value="Cuprum">Cuprum</option>
		<option value="Cuprum:400,400italic,700italic,700">Cuprum (plus bold and italic)</option>
		<option value="Cutive">Cutive</option>
		<option value="Damion">Damion</option>
		<option value="Dancing Script">Dancing Script</option>
		<option value="Dawning of a New Day">Dawning of a New Day</option>
		<option value="Days One">Days One </option>
		<option value="Delius Swash Caps">Delius Swash Caps </option>
		<option value="Delius Unicase">Delius Unicase </option>
		<option value="Delius">Delius </option>
		<option value="Della Respira">Della Respira</option>
		<option value="Devonshire">Devonshire</option>
		<option value="Didact Gothic">Didact Gothic</option>
		<option value="Diplomata SC">Diplomata SC</option>
		<option value="Diplomata">Diplomata</option>
		<option value="Doppio One">Doppio One</option>
		<option value="Dorsa">Dorsa</option>
		<option value="Dosis">Dosis</option>
		<option value="Dosis:200,300,400,500,600,700,800">Dosis (all weights)</option>
		<option value="Dr Sugiyama">Dr Sugiyama</option>
		<option value="Droid Sans Mono">Droid Sans Mono</option>
		<option value="Droid Sans">Droid Sans</option>
		<option value="Droid Sans:regular,bold">Droid Sans (plus bold)</option>
		<option value="Droid Serif">Droid Serif</option>
		<option value="Droid Serif:regular,italic,bold,bolditalic">Droid Serif (plus italic, bold, and bold italic)</option>
		<option value="Duru Sans">Duru Sans</option>
		<option value="Dynalight">Dynalight</option>
		<option value="EB Garamond">EB Garamond</option>
		<option value="Eagle Lake">Eagle Lake</option>
		<option value="Eater">Eater</option>
		<option value="Economica">Economica</option>
		<option value="Economica:400,400italic,700,700italic">Economica (plus all weights and italics)</option>
		<option value="Electrolize">Electrolize</option>
		<option value="Emblema One">Emblema One</option>
		<option value="Emilys Candy">Emilys Candy</option>
		<option value="Engagement">Engagement</option>
		<option value="Enriqueta">Enriqueta</option>
		<option value="Enriqueta:400,700">Enriqueta:400,700</option>
		<option value="Erica One">Erica One</option>
		<option value="Esteban">Esteban</option>
		<option value="Euphoria Script">Euphoria Script</option>
		<option value="Ewert">Ewert</option>
		<option value="Exo">Exo</option>
		<option value="Exo:100,100italic,200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic">Exo (plus all weights and italics)</option>
		<option value="Expletus Sans">Expletus Sans</option>
		<option value="Expletus Sans:regular,500,600,bold">Expletus Sans (plus 500, 600, and bold)</option>
		<option value="Fanwood Text">Fanwood Text</option>
		<option value="Fanwood Text:400,400italic">Fanwood Text (plus italic)</option>
		<option value="Fascinate Inline">Fascinate Inline</option>
		<option value="Fascinate">Fascinate</option>
		<option value="Fasthand">Fasthand</option>
		<option value="Federant">Federant</option>
		<option value="Federo">Federo </option>
		<option value="Felipa">Felipa</option>
		<option value="Fjord One">Fjord One</option>
		<option value="Flamenco">Flamenco</option>
		<option value="Flamenco:300">Flamenco:300</option>
		<option value="Flavors">Flavors</option>
		<option value="Fondamento">Fondamento</option>
		<option value="Fondamento:400,400italic">Fondamento:400,400italic</option>
		<option value="Fontdiner Swanky">Fontdiner Swanky</option>
		<option value="Forum">Forum</option>
		<option value="Francois One">Francois One</option>
		<option value="Fredoka One">Fredoka One</option>
		<option value="Fresca">Fresca</option>
		<option value="Frijole">Frijole</option>
		<option value="Fugaz One">Fugaz One</option>
		<option value="Galdeano">Galdeano</option>
		<option value="Galindo">Galindo</option>
		<option value="Gentium Basic">Gentium Basic </option>
		<option value="Gentium Basic:400,700,400italic,700italic">Gentium Basic (plus bold and italic) </option>
		<option value="Gentium Book Basic">Gentium Book Basic </option>
		<option value="Gentium Book Basic:400,400italic,700,700italic">Gentium Book Basic (plus bold and italic) </option>
		<option value="Geo">Geo</option>
		<option value="Geostar Fill">Geostar Fill </option>
		<option value="Geostar">Geostar </option>
		<option value="Germania One">Germania One</option>
		<option value="Give You Glory">Give You Glory</option>
		<option value="Glass Antiqua">Glass Antiqua</option>
		<option value="Glegoo">Glegoo</option>
		<option value="Gloria Hallelujah">Gloria Hallelujah </option>
		<option value="Goblin One">Goblin One</option>
		<option value="Gochi Hand">Gochi Hand</option>
		<option value="Gochi Hand:400">Gochi Hand:400</option>
		<option value="Gorditas">Gorditas</option>
		<option value="Gorditas:400,bold">Gorditas (plus bold)</option>
		<option value="Goudy Bookletter 1911">Goudy Bookletter 1911</option>
		<option value="Graduate">Graduate</option>
		<option value="Gravitas One">Gravitas One</option>
		<option value="Great Vibes">Great Vibes</option>
		<option value="Gruppo">Gruppo</option>
		<option value="Gudea">Gudea</option>
		<option value="Gudea:400,italic,bold">Gudea:400,italic,bold</option>
		<option value="Habibi">Habibi</option>
		<option value="Hammersmith One">Hammersmith One</option>
		<option value="Handlee">Handlee</option>
		<option value="Happy Monkey">Happy Monkey</option>
		<option value="Henny Penny">Henny Penny</option>
		<option value="Herr Von Muellerhoff">Herr Von Muellerhoff</option>
		<option value="Holtwood One SC">Holtwood One SC</option>
		<option value="Homemade Apple">Homemade Apple</option>
		<option value="Homenaje">Homenaje</option>
		<option value="IM Fell DW Pica SC">IM Fell DW Pica SC</option>
		<option value="IM Fell DW Pica">IM Fell DW Pica</option>
		<option value="IM Fell DW Pica:regular,italic">IM Fell DW Pica (plus italic)</option>
		<option value="IM Fell Double Pica SC">IM Fell Double Pica SC</option>
		<option value="IM Fell Double Pica">IM Fell Double Pica</option>
		<option value="IM Fell Double Pica:regular,italic">IM Fell Double Pica (plus italic)</option>
		<option value="IM Fell English SC">IM Fell English SC</option>
		<option value="IM Fell English">IM Fell English</option>
		<option value="IM Fell English:regular,italic">IM Fell English (plus italic)</option>
		<option value="IM Fell French Canon SC">IM Fell French Canon SC</option>
		<option value="IM Fell French Canon">IM Fell French Canon</option>
		<option value="IM Fell French Canon:regular,italic">IM Fell French Canon (plus italic)</option>
		<option value="IM Fell Great Primer SC">IM Fell Great Primer SC</option>
		<option value="IM Fell Great Primer">IM Fell Great Primer</option>
		<option value="IM Fell Great Primer:regular,italic">IM Fell Great Primer (plus italic)</option>
		<option value="Iceberg">Iceberg</option>
		<option value="Iceland">Iceland</option>
		<option value="Imprima">Imprima</option>
		<option value="Inconsolata">Inconsolata</option>
		<option value="Inder">Inder</option>
		<option value="Indie Flower">Indie Flower</option>
		<option value="Inika">Inika</option>
		<option value="Inika:400,bold">Inika (plus bold)</option>
		<option value="Irish Grover">Irish Grover</option>
		<option value="Irish Growler">Irish Growler</option>
		<option value="Istok Web">Istok Web</option>
		<option value="Istok Web:400,700,400italic,700italic">Istok Web (plus italic, bold, and bold italic)</option>
		<option value="Italiana">Italiana</option>
		<option value="Italianno">Italianno</option>
		<option value="Jim Nightshade">Jim Nightshade</option>
		<option value="Jockey One">Jockey One</option>
		<option value="Jolly Lodger">Jolly Lodger</option>
		<option value="Josefin Sans">Josefin Sans Regular 400</option>
		<option value="Josefin Sans:100">Josefin Sans 100</option>
		<option value="Josefin Sans:100,100italic">Josefin Sans 100 (plus italic)</option>
		<option value="Josefin Sans:600">Josefin Sans 600</option>
		<option value="Josefin Sans:600,600italic">Josefin Sans 600 (plus italic)</option>
		<option value="Josefin Sans:bold">Josefin Sans Bold 700</option>
		<option value="Josefin Sans:bold,bolditalic">Josefin Sans Bold 700 (plus italic)</option>
		<option value="Josefin Sans:light">Josefin Sans Light 300</option>
		<option value="Josefin Sans:light,lightitalic">Josefin Sans Light 300 (plus italic)</option>
		<option value="Josefin Sans:regular,regularitalic">Josefin Sans Regular 400 (plus italic)</option>
		<option value="Josefin Slab">Josefin Slab Regular 400</option>
		<option value="Josefin Slab:100">Josefin Slab 100</option>
		<option value="Josefin Slab:100,100italic">Josefin Slab 100 (plus italic)</option>
		<option value="Josefin Slab:600">Josefin Slab 600</option>
		<option value="Josefin Slab:600,600italic">Josefin Slab 600 (plus italic)</option>
		<option value="Josefin Slab:bold">Josefin Slab Bold 700</option>
		<option value="Josefin Slab:bold,bolditalic">Josefin Slab Bold 700 (plus italic)</option>
		<option value="Josefin Slab:light">Josefin Slab Light 300</option>
		<option value="Josefin Slab:light,lightitalic">Josefin Slab Light 300 (plus italic)</option>
		<option value="Josefin Slab:regular,regularitalic">Josefin Slab Regular 400 (plus italic)</option>
		<option value="Judson">Judson</option>
		<option value="Judson:regular,regularitalic,bold">Judson (plus bold)</option>
		<option value="Julee">Julee</option>
		<option value="Junge">Junge</option>
		<option value="Jura"> Jura Regular</option>
		<option value="Jura:500"> Jura 500</option>
		<option value="Jura:600"> Jura 600</option>
		<option value="Jura:light"> Jura Light</option>
		<option value="Just Another Hand">Just Another Hand</option>
		<option value="Just Me Again Down Here">Just Me Again Down Here</option>
		<option value="Kameron">Kameron</option>
		<option value="Kameron:400,700">Kameron (plus bold)</option>
		<option value="Karla">Karla</option>
		<option value="Karla:400,400italic,700,700italic">Karla (plus all weights and italics)</option>
		<option value="Kaushan Script">Kaushan Script</option>
		<option value="Kelly Slab">Kelly Slab </option>
		<option value="Kenia">Kenia</option>
		<option value="Knewave">Knewave</option>
		<option value="Kotta One">Kotta One</option>
		<option value="Kranky">Kranky</option>
		<option value="Kreon">Kreon</option>
		<option value="Kreon:light,regular,bold">Kreon (plus light and bold)</option>
		<option value="Kristi">Kristi</option>
		<option value="Krona One">Krona One</option>
		<option value="La Belle Aurore">La Belle Aurore</option>
		<option value="Lancelot">Lancelot</option>
		<option value="Lato:100">Lato 100</option>
		<option value="Lato:100,100italic">Lato 100 (plus italic)</option>
		<option value="Lato:900">Lato 900</option>
		<option value="Lato:900,900italic">Lato 900 (plus italic)</option>
		<option value="Lato:bold">Lato Bold 700</option>
		<option value="Lato:bold,bolditalic">Lato Bold 700 (plus italic)</option>
		<option value="Lato:light">Lato Light 300</option>
		<option value="Lato:light,lightitalic">Lato Light 300 (plus italic)</option>
		<option value="Lato:regular">Lato Regular 400</option>
		<option value="Lato:regular,regularitalic">Lato Regular 400 (plus italic)</option>
		<option value="League Script">League Script</option>
		<option value="Leckerli One">Leckerli One </option>
		<option value="Ledger">Ledger</option>
		<option value="Lekton"> Lekton </option>
		<option value="Lekton:regular,italic,bold">Lekton (plus italic and bold)</option>
		<option value="Lemon">Lemon</option>
		<option value="Life Savers">Life Savers</option>
		<option value="Lilita One">Lilita One</option>
		<option value="Limelight"> Limelight </option>
		<option value="Linden Hill">Linden Hill</option>
		<option value="Linden Hill:400,400italic">Linden Hill:400,400italic</option>
		<option value="Lobster Two">Lobster Two</option>
		<option value="Lobster Two:400,400italic,700,700italic">Lobster Two (plus italic, bold, and bold italic)</option>
		<option value="Lobster">Lobster</option>
		<option value="Londrina Outline">Londrina Outline</option>
		<option value="Londrina Shadow">Londrina Shadow</option>
		<option value="Londrina Sketch">Londrina Sketch</option>
		<option value="Londrina Solid">Londrina Solid</option>
		<option value="Lora">Lora</option>
		<option value="Lora:400,700,400italic,700italic">Lora (plus bold and italic)</option>
		<option value="Love Ya Like A Sister">Love Ya Like A Sister</option>
		<option value="Lovers Quarrel">Lovers Quarrel</option>
		<option value="Loved by the King">Loved by the King</option>
		<option value="Luckiest Guy">Luckiest Guy</option>
		<option value="Lusitana">Lusitana</option>
		<option value="Lusitana:400,bold">Lusitana (plus bold)</option>
		<option value="Lustria">Lustria</option>
		<option value="Macondo Swash Caps">Macondo Swash Caps</option>
		<option value="Macondo">Macondo</option>
		<option value="Magra">Magra</option>
		<option value="Magra:400,bold">Magra (plus bold)</option>
		<option value="Maiden Orange">Maiden Orange</option>
		<option value="Mako">Mako</option>
		<option value="Marck Script">Marck Script</option>
		<option value="Marko One">Marko One</option>
		<option value="Marmelad">Marmelad</option>
		<option value="Marvel">Marvel </option>
		<option value="Marvel:400,400italic,700,700italic">Marvel (plus bold and italic) </option>
		<option value="Mate SC">Mate SC</option>
		<option value="Mate">Mate</option>
		<option value="Mate:400,400italic">Mate:400,400italic</option>
		<option value="Maven Pro"> Maven Pro</option>
		<option value="Maven Pro:500"> Maven Pro 500</option>
		<option value="Maven Pro:900"> Maven Pro 900</option>
		<option value="Maven Pro:bold"> Maven Pro 700</option>
		<option value="McLaren">McLaren</option>
		<option value="Meddon">Meddon</option>
		<option value="MedievalSharp">MedievalSharp</option>
		<option value="Medula One">Medula One</option>
		<option value="Megrim">Megrim</option>
		<option value="Merienda One">Merienda One</option>
		<option value="Merriweather">Merriweather</option>
		<option value="Metamorphous">Metamorphous</option>
		<option value="Metrophobic">Metrophobic</option>
		<option value="Metal Mania">Metal Mania</option>
		<option value="Michroma">Michroma</option>
		<option value="Miltonian Tattoo">Miltonian Tattoo</option>
		<option value="Miltonian">Miltonian</option>
		<option value="Miniver">Miniver</option>
		<option value="Miss Fajardose">Miss Fajardose</option>
		<option value="Miss Saint Delafield">Miss Saint Delafield</option>
		<option value="Modern Antiqua">Modern Antiqua</option>
		<option value="Molengo">Molengo</option>
		<option value="Monofett">Monofett</option>
		<option value="Monoton">Monoton </option>
		<option value="Monsieur La Doulaise">Monsieur La Doulaise</option>
		<option value="Montaga">Montaga</option>
		<option value="Montez">Montez </option>
		<option value="Montserrat">Montserrat</option>
		<option value="Mountains of Christmas">Mountains of Christmas</option>
		<option value="Mr Bedford">Mr Bedford</option>
		<option value="Mr Dafoe">Mr Dafoe</option>
		<option value="Mr De Haviland">Mr De Haviland</option>
		<option value="Mrs Saint Delafield">Mrs Saint Delafield</option>
		<option value="Mrs Sheppards">Mrs Sheppards</option>
		<option value="Muli">Muli Regular</option>
		<option value="Muli:light">Muli Light</option>
		<option value="Muli:light,lightitalic">Muli Light (plus italic)</option>
		<option value="Muli:regular,regularitalic">Muli Regular (plus italic)</option>
		<option value="Mystery Quest">Mystery Quest</option>
		<option value="Neucha">Neucha</option>
		<option value="Neuton">Neuton</option>
		<option value="News Cycle">News Cycle</option>
		<option value="Niconne">Niconne</option>
		<option value="Nixie One">Nixie One</option>
		<option value="Nobile">Nobile</option>
		<option value="Nobile:regular,italic,bold,bolditalic">Nobile (plus italic, bold, and bold italic)</option>
		<option value="Nokora">Nokora</option>
		<option value="Nokora:400,700">Nokora:400,700</option>
		<option value="Norican">Norican</option>
		<option value="Nosifer">Nosifer</option>
		<option value="Noticia Text">Noticia Text</option>
		<option value="Noticia Text:400,400italic,700,700italic">Noticia Text:400,400italic,700,700italic</option>
		<option value="Nova Cut">Nova Cut</option>
		<option value="Nova Flat">Nova Flat</option>
		<option value="Nova Mono">Nova Mono</option>
		<option value="Nova Oval">Nova Oval</option>
		<option value="Nova Round">Nova Round</option>
		<option value="Nova Script">Nova Script</option>
		<option value="Nova Slim">Nova Slim</option>
		<option value="Nova Square">Nova Square</option>
		<option value="Numans">Numans </option>
		<option value="Nunito"> Nunito Regular</option>
		<option value="Nunito:light"> Nunito Light</option>
		<option value="OFL Sorts Mill Goudy TT">OFL Sorts Mill Goudy TT</option>
		<option value="OFL Sorts Mill Goudy TT:regular,italic">OFL Sorts Mill Goudy TT (plus italic)</option>
		<option value="Old Standard TT">Old Standard TT</option>
		<option value="Old Standard TT:regular,italic,bold">Old Standard TT (plus italic and bold)</option>
		<option value="Oldenburg">Oldenburg</option>
		<option value="Oleo Script">Oleo Script</option>
		<option value="Oleo Script:400,700">Oleo Script (plus bold)</option>
		<option value="Open Sans Condensed">Open Sans Condensed</option>
		<option value="Open Sans Condensed:300,300italic,700">Open Sans Condensed (plus all weights and italics)</option>
		<option value="Open Sans Condensed:light,lightitalic">Open Sans Condensed Light (plus italic)</option>
		<option value="Open Sans:600,600italic">Open Sans 600</option>
		<option value="Open Sans:800,800italic">Open Sans 800</option>
		<option value="Open Sans:bold,bolditalic">Open Sans bold</option>
		<option value="Open Sans:light,lightitalic">Open Sans light</option>
		<option value="Open Sans:light,lightitalic,regular,regularitalic,600,600italic,bold,bolditalic,800,800italic">Open Sans (all weights)</option>
		<option value="Open Sans:regular,regularitalic">Open Sans regular</option>
		<option value="Orbitron">Orbitron Regular (400)</option>
		<option value="Orbitron:500">Orbitron 500</option>
		<option value="Orbitron:900">Orbitron 900</option>
		<option value="Orbitron:bold">Orbitron Regular (700)</option>
		<option value="Oregano">Oregano</option>
		<option value="Oregano:400,400italic">Oregano (plus italic)</option>
		<option value="Original Surfer">Original Surfer</option>
		<option value="Oswald">Oswald</option>
		<option value="Over the Rainbow">Over the Rainbow</option>
		<option value="Overlock SC">Overlock SC</option>
		<option value="Overlock">Overlock</option>
		<option value="Overlock:400,400italic,700,700italic,900,900italic">Overlock:400,400italic,700,700italic,900,900italic</option>
		<option value="Ovo">Ovo </option>
		<option value="Oxygen">Oxygen</option>
		<option value="PT Mono">PT Mono</option>
		<option value="PT Sans Caption">PT Sans Caption</option>
		<option value="PT Sans Caption:regular,bold">PT Sans Caption (plus bold)</option>
		<option value="PT Sans Narrow">PT Sans Narrow</option>
		<option value="PT Sans Narrow:regular,bold">PT Sans Narrow (plus bold)</option>
		<option value="PT Sans">PT Sans</option>
		<option value="PT Sans:regular,italic,bold,bolditalic">PT Sans (plus itlic, bold, and bold italic)</option>
		<option value="PT Serif Caption">PT Serif Caption</option>
		<option value="PT Serif Caption:regular,italic">PT Serif Caption (plus italic)</option>
		<option value="PT Serif">PT Serif</option>
		<option value="PT Serif:regular,italic,bold,bolditalic">PT Serif (plus italic, bold, and bold italic)</option>
		<option value="Pacifico">Pacifico</option>
		<option value="Parisienne">Parisienne</option>
		<option value="Passero One">Passero One</option>
		<option value="Passion One">Passion One</option>
		<option value="Passion One:400,700,900">Passion One:400,700,900</option>
		<option value="Patrick Hand">Patrick Hand</option>
		<option value="Patua One">Patua One</option>
		<option value="Paytone One">Paytone One</option>
		<option value="Peralta">Peralta</option>
		<option value="Permanent Marker">Permanent Marker</option>
		<option value="Petrona">Petrona</option>
		<option value="Philosopher">Philosopher</option>
		<option value="Piedra">Piedra</option>
		<option value="Pinyon Script">Pinyon Script</option>
		<option value="Plaster">Plaster</option>
		<option value="Play">Play</option>
		<option value="Play:regular,bold">Play (plus bold)</option>
		<option value="Playball">Playball</option>
		<option value="Playfair Display"> Playfair Display </option>
		<option value="Podkova"> Podkova </option>
		<option value="Poiret One">Poiret One</option>
		<option value="Poller One">Poller One</option>
		<option value="Poly">Poly</option>
		<option value="Poly:400,400italic">Poly:400,400italic</option>
		<option value="Pompiere">Pompiere </option>
		<option value="Pontano Sans">Pontano Sans</option>
		<option value="Port Lligat Sans">Port Lligat Sans</option>
		<option value="Port Lligat Slab">Port Lligat Slab</option>
		<option value="Prata">Prata</option>
		<option value="Press Start 2P">Press Start 2P</option>
		<option value="Princess Sofia">Princess Sofia</option>
		<option value="Prociono">Prociono</option>
		<option value="Prosto One">Prosto One</option>
		<option value="Puritan">Puritan</option>
		<option value="Puritan:regular,italic,bold,bolditalic">Puritan (plus italic, bold, and bold italic)</option>
		<option value="Quando">Quando</option>
		<option value="Quantico">Quantico</option>
		<option value="Quantico:400,400italic,700,700italic">Quantico:400,400italic,700,700italic</option>
		<option value="Quattrocento Sans">Quattrocento Sans</option>
		<option value="Quattrocento Sans:400,400italic,700,700italic">Quattrocento Sans (plus bolds and italics)</option>
		<option value="Quattrocento">Quattrocento</option>
		<option value="Quattrocento:400,700">Quattrocento (plus bold)</option>
		<option value="Questrial">Questrial </option>
		<option value="Quicksand">Quicksand</option>
		<option value="Quicksand:300,400,700">Quicksand:300,400,700</option>
		<option value="Qwigley">Qwigley</option>
		<option value="Racing Sans One">Racing Sans One</option>
		<option value="Radley">Radley</option>
		<option value="Raleway:100">Raleway</option>
		<option value="Rammetto One">Rammetto One</option>
		<option value="Rancho">Rancho</option>
		<option value="Rationale">Rationale </option>
		<option value="Redressed">Redressed</option>
		<option value="Reenie Beanie">Reenie Beanie</option>
		<option value="Revalia">Revalia</option>
		<option value="Ribeye Marrow">Ribeye Marrow</option>
		<option value="Ribeye">Ribeye</option>
		<option value="Righteous">Righteous</option>
		<option value="Rochester">Rochester </option>
		<option value="Rock Salt">Rock Salt</option>
		<option value="Rokkitt">Rokkitt</option>
		<option value="Romanesco">Romanesco</option>
		<option value="Ropa Sans">Ropa Sans</option>
		<option value="Ropa Sans:400,400italic">Ropa Sans (plus italics)</option>
		<option value="Rosario">Rosario </option>
		<option value="Rosarivo:400,400italic">Rosarivo (plus italic)</option>		<option value="Rouge Script">Rouge Script</option>
		<option value="Ruda">Ruda</option>
		<option value="Ruda:400,bold,900">Ruda (plus all bold and 900)</option>
		<option value="Ruge Boogie">Ruge Boogie</option>
		<option value="Ruluko">Ruluko</option>
		<option value="Ruslan Display">Ruslan Display</option>
		<option value="Russo One">Russo One</option>
		<option value="Ruthie">Ruthie</option>
		<option value="Sail">Sail</option>
		<option value="Salsa">Salsa</option>
		<option value="Sancreek">Sancreek</option>
		<option value="Sansita One">Sansita One</option>
		<option value="Sarina">Sarina</option>
		<option value="Satisfy">Satisfy</option>
		<option value="Schoolbell">Schoolbell</option>
		<option value="Seaweed Script">Seaweed Script</option>
		<option value="Sevillana">Sevillana</option>
		<option value="Shadows Into Light Two">Shadows Into Light Two</option>
		<option value="Shadows Into Light">Shadows Into Light</option>
		<option value="Shanti">Shanti</option>
		<option value="Share">Share</option>
		<option value="Share:400,400italic,700,700italic">Share (plus all weights and italics)</option>
		<option value="Shojumaru">Shojumaru</option>
		<option value="Short Stack">Short Stack </option>
		<option value="Sigmar One">Sigmar One</option>
		<option value="Signika Negative">Signika Negative</option>
		<option value="Signika Negative:300,400,600,700">Signika Negative:300,400,600,700</option>
		<option value="Signika">Signika</option>
		<option value="Signika:300,400,600,700">Signika:300,400,600,700</option>
		<option value="Simonetta">Simonetta</option>
		<option value="Simonetta:400,400italic">Simonetta (plus italic)</option>
		<option value="Sirin Stencil">Sirin Stencil</option>
		<option value="Six Caps">Six Caps</option>
		<option value="Slackey">Slackey</option>
		<option value="Smokum">Smokum </option>
		<option value="Smythe">Smythe</option>
		<option value="Sniglet:800">Sniglet</option>
		<option value="Snippet">Snippet </option>
		<option value="Sofia">Sofia</option>
		<option value="Sonsie One">Sonsie One</option>
		<option value="Sorts Mill Goudy">Sorts Mill Goudy</option>
		<option value="Sorts Mill Goudy:400,400italic">Sorts Mill Goudy (plus italic)</option>
		<option value="Source Sans Pro">Source Sans Pro</option>
		<option value="Source Sans Pro:200,300,400,600,700,900,200italic,300italic,400italic,600italic,700italic,900italic">Source Sans Pro (all weights plus italics)</option>
		<option value="Special Elite">Special Elite</option>
		<option value="Spicy Rice">Spicy Rice</option>
		<option value="Spinnaker">Spinnaker</option>
		<option value="Spirax">Spirax</option>
		<option value="Squada One">Squada One</option>
		<option value="Stardos Stencil">Stardos Stencil</option>
		<option value="Stardos Stencil:400,700">Stardos Stencil (plus bold)</option>
		<option value="Stint Ultra Condensed">Stint Ultra Condensed</option>
		<option value="Stint Ultra Expanded">Stint Ultra Expanded</option>
		<option value="Stoke">Stoke</option>
		<option value="Stoke:400,300">Stoke (plus 400)</option>
		<option value="Sue Ellen Francisco">Sue Ellen Francisco</option>
		<option value="Sunshiney">Sunshiney</option>
		<option value="Supermercado One">Supermercado One</option>
		<option value="Swanky and Moo Moo">Swanky and Moo Moo</option>
		<option value="Syncopate">Syncopate</option>
		<option value="Tangerine">Tangerine</option>
		<option value="Telex">Telex</option>
		<option value="Tenor Sans"> Tenor Sans </option>
		<option value="Terminal Dosis Light">Terminal Dosis Light</option>
		<option value="Terminal Dosis">Terminal Dosis Regular</option>
		<option value="Terminal Dosis:200">Terminal Dosis 200</option>
		<option value="Terminal Dosis:300">Terminal Dosis 300</option>
		<option value="Terminal Dosis:500">Terminal Dosis 500</option>
		<option value="Terminal Dosis:600">Terminal Dosis 600</option>
		<option value="Terminal Dosis:700">Terminal Dosis 700</option>
		<option value="Terminal Dosis:800">Terminal Dosis 800</option>
		<option value="The Girl Next Door">The Girl Next Door</option>
		<option value="Tinos">Tinos</option>
		<option value="Tinos:regular,italic,bold,bolditalic">Tinos (plus italic, bold, and bold italic)</option>
		<option value="Titan One">Titan One</option>
		<option value="Trade Winds">Trade Winds</option>
		<option value="Trocchi">Trocchi</option>
		<option value="Trochut">Trochut</option>
		<option value="Trochut:400,italic,bold">Trochut (plus bold and italic)</option>
		<option value="Trykker">Trykker</option>
		<option value="Tulpen One">Tulpen One </option>
		<option value="Ubuntu Condensed">Ubuntu Condensed</option>
		<option value="Ubuntu Mono">Ubuntu Mono</option>
		<option value="Ubuntu Mono:regular,italic,bold,bolditalic">Ubuntu Mono:regular,italic,bold,bolditalic</option>
		<option value="Ubuntu">Ubuntu</option>
		<option value="Ubuntu:regular,italic,bold,bolditalic">Ubuntu (plus italic, bold, and bold italic)</option>
		<option value="Ultra">Ultra</option>
		<option value="Uncial Antiqua">Uncial Antiqua</option>
		<option value="UnifrakturCook:bold">UnifrakturCook</option>
		<option value="UnifrakturMaguntia">UnifrakturMaguntia</option>
		<option value="Unkempt">Unkempt</option>
		<option value="Unlock">Unlock</option>
		<option value="Unna">Unna </option>
		<option value="VT323">VT323</option>
		<option value="Varela Round">Varela Round</option>
		<option value="Varela">Varela</option>
		<option value="Vast Shadow">Vast Shadow</option>
		<option value="Vibur">Vibur</option>
		<option value="Vidaloka">Vidaloka </option>
		<option value="Viga">Viga</option>
		<option value="Voces">Voces</option>
		<option value="Volkhov">Volkhov </option>
		<option value="Volkhov:400,400italic,700,700italic">Volkhov (plus bold and italic) </option>
		<option value="Vollkorn">Vollkorn</option>
		<option value="Vollkorn:regular,italic,bold,bolditalic">Vollkorn (plus italic, bold, and bold italic)</option>
		<option value="Voltaire">Voltaire </option>
		<option value="Waiting for the Sunrise">Waiting for the Sunrise</option>
		<option value="Wallpoet">Wallpoet</option>
		<option value="Walter Turncoat">Walter Turncoat</option>
		<option value="Wellfleet">Wellfleet</option>
		<option value="Wire One">Wire One</option>
		<option value="Yanone Kaffeesatz">Yanone Kaffeesatz</option>
		<option value="Yanone Kaffeesatz:300">Yanone Kaffeesatz:300</option>
		<option value="Yanone Kaffeesatz:400">Yanone Kaffeesatz:400</option>
		<option value="Yanone Kaffeesatz:700">Yanone Kaffeesatz:700</option>
		<option value="Yellowtail">Yellowtail </option>
		<option value="Yeseva One">Yeseva One</option>
		<option value="Yesteryear">Yesteryear</option>
		<option value="Zeyada">Zeyada</option>
';
	}
?>

<p><strong>Menu font:</strong><br/>
<select style="width:430px; height:35px; padding-left:10px; border:1px solid #ccc; background: #F7F7F7; margin-top:5px; margin-bottom:10px;" name="googlefonts_font1" id="googlefonts_font1">
<option selected="selected"><?php echo $this->options['googlefonts_font1'] ;?></option>
<?php listgooglefontoptions(); ?>
</select></p>


<p><strong>All heading font:</strong><br/>
<select style="width:430px; height:35px; padding-left:10px; border:1px solid #ccc; background: #F7F7F7; margin-top:5px; margin-bottom:10px;" name="googlefonts_font2" id="googlefonts_font2">
<option selected="selected"><?php echo $this->options['googlefonts_font2'] ;?></option>
<?php listgooglefontoptions(); ?>
</select></p>


<p><strong>Body font:</strong><br/>
<select style="width:430px; height:35px; padding-left:10px; border:1px solid #ccc; background: #F7F7F7; margin-top:5px; margin-bottom:10px;" name="googlefonts_font3" id="googlefonts_font3">
<option selected="selected"><?php echo $this->options['googlefonts_font3'] ;?></option>
<?php listgooglefontoptions(); ?>
</select></p>


<p><input type="submit" class="button-primary" name="googlefonts_save" value="Save changes" /> &nbsp;<a class="button" href="http://www.google.com/webfonts/" target="_blank">Google font preview</a></p>


</form>
    </td>
  </tr>
</table>

<?php }
  } //End Class
} //End if class exists statement

//instantiate the class
if (class_exists('googlefonts')) {
    $googlefonts_var = new googlefonts();
}
?>