<?php

class Bookitme {

    function __construct() {
        //$this->setDefaultValues();
        $this->options = get_option('bookitme_options');
        
        if ($_POST['inp_calendar_width']) {
            $lov['inp_calendar_width'] = intval($_POST['inp_calendar_width']);
        } else {
            $lov['inp_calendar_width'] = $this->options['inp_calendar_width'];
        }

        if ($_POST['inp_calendar_height']) {
            $lov['inp_calendar_height'] = intval($_POST['inp_calendar_height']);
        } else {
            $lov['inp_calendar_height'] = $this->options['inp_calendar_height'];
        }

        if ($_POST['inp_calendar_url']) {
            $lov['inp_calendar_url'] = htmlspecialchars($_POST['inp_calendar_url']);
        } else {
            $lov['inp_calendar_url'] = $this->options['inp_calendar_url'];
        }

        if ($_POST['inp_timeline_width']) {
            $lov['inp_timeline_width'] = intval($_POST['inp_timeline_width']);
        } else {
            $lov['inp_timeline_width'] = $this->options['inp_timeline_width'];
        }

        if ($_POST['inp_timeline_height']) {
            $lov['inp_timeline_height'] = intval($_POST['inp_timeline_height']);
        } else {
            $lov['inp_timeline_height'] = $this->options['inp_timeline_height'];
        }

        if ($_POST['inp_timeline_url']) {
            $lov['inp_timeline_url'] = htmlspecialchars($_POST['inp_timeline_url']);
        } else {
            $lov['inp_timeline_url'] = $this->options['inp_timeline_url'];
        }
      
        $this->updateParams($lov);



        $this->options = get_option('bookitme_options');
        add_action('admin_menu', array(&$this, 'bookitmeAdminMenu'));
    }

    function updateParams($lov) {
        update_option('bookitme_options', $lov);
    }

    function bookitmeAdminMenu() {
        //create a sub admin panel link above
        add_menu_page('Bookitme calendar', 'Bookitme', 'administrator', 8, array(&$this, 'overview'));
        add_submenu_page(8, 'Settings', 'Settings', 'administrator', 1, array(&$this, 'bookitmeRenderForm'));
    }

    function overview() {
        $pld = plugins_url() . '/bookitme-booking-calendar/lib/images/logo7.png';
        $pld1 = plugins_url() . '/bookitme-booking-calendar/lib/images/admin_calendar_type.jpg';
        echo "<div style=\"wifth:80%;text-align:left;  \"><p><img src=\"$pld\" /></p>";
        echo "<p style=\"font-size:17px;\">Simple way to display booking calendar in post or page simply adding a shortcode <br><strong>[bookitme-calendar] [bookitme-timeline]</strong> and  to a page.<p> 
              <p style=\"font-size:17px;\">See the Plugin screenshots for examples.</p>
              <p>This gives your visitors an efficient way to view ALL booking calendar from bookitme.com site on ONE place.</p> 
              <p><strong>Shortodes:</strong></p>
              <p><strong>[bookitme-calendar]</strong> – display calendar on page or post</p> 
              <p>params: [bookitme-calendar width=\"500\" height=\"500\" url=\"http://www.bookitme.com/bookitme-demo-13/tms2.html\"]</p>
              <p><strong>[bookitme-timeline]</strong></p>
              <p>params: [bookitme-timeline width=\"700\" height=\"500\" url=\"http://www.bookitme.com/tms-time-13/index.php\"]</p>  
              <p><strong>Admin Page:</strong> all shortcode input parameters are setup in admin page. If you not specified input parameters in shortcode definition default values from Admin panel will be used.</p> 
              <p style=\"font-size:17px;\">See  <a href=\"http://www.bookitme.com\" style=\"font-size:17px;\" target=\"_blank\">www.bookitme.com</a> for more information.</p>
              <p><img src=\"$pld1\" /></p>              
              </div>";
    }

    function setDefaultValues() {
        if ($this->options['inp_calendar_width'] == 0) {
            $setVal['inp_calendar_width'] = '500';
        } else {
            $setVal['inp_calendar_width'] = $this->options['inp_calendar_width'];
        }
        if ($this->options['inp_calendar_height'] == 0) {
            $setVal['inp_calendar_height'] = '500';
        } else {
            $setVal['inp_calendar_height'] = $this->options['inp_calendar_height'];
        }
        if (!$this->options['inp_calendar_url']) {
            $setVal['inp_calendar_url'] = 'http://www.bookitme.com/bookitme-demo-13/tms2.html';
        } else {
            $setVal['inp_calendar_url'] = $this->options['inp_calendar_url'];
        }
        if ($this->options['inp_timeline_width'] == 0) {
            $setVal['inp_timeline_width'] = '700';
        } else {
            $setVal['inp_timeline_width'] = $this->options['inp_timeline_width'];
        }
        if ($this->options['inp_timeline_height'] == 0) {
            $setVal['inp_timeline_height'] = '500';
        } else {
            $setVal['inp_timeline_height'] = $this->options['inp_timeline_height'];
        }
        if (!$this->options['inp_timeline_url']) {
            $setVal['inp_timeline_url'] = 'http://www.bookitme.com/tms-time-13/index.php';
        } else {
            $setVal['inp_timeline_url'] = $this->options['inp_timeline_url'];
        }

        $this->updateParams($setVal);
    }

    function bookitmeRenderForm() {
        $pld = plugins_url() . '/bookitme-booking-calendar/lib/images/logo7.png';

        $form = "<div style=\"wifth:80%;text-align:left;  \"><p><img src=\"$pld\" /></p>";
        $form .= '
        <form method="post" action="' . $_SERVER["REQUEST_URI"] . '">
            <table class="form-table">
                <tr valign="top">
                <tr><td colspan="2"><div style="margin-top:10px;"><h1>CALENDAR default values:</h1></div></td></tr>
                <th scope="row">Display size <strong>WIDTH :</strong></th>
                <td><input type="text" name="inp_calendar_width" value="' . $this->options['inp_calendar_width'] . '" /><span style="font-style:italic;padding:10px;">default : 500px</span></td>
                <tr><td scope="row">Display size <strong>HEIGHT :</strong></td>
                    <td><input type="text" name="inp_calendar_height" value="' . $this->options['inp_calendar_height'] . '" /><span style="font-style:italic;padding:10px;">default : 400px</span></td></tr>         
                <tr><td scope="row">Calendar <strong>URL :</strong></td>
                    <td><input type="text" name="inp_calendar_url" size="60" value="' . $this->options['inp_calendar_url'] . '" /><span style="font-style:italic;padding:10px;">default : http://www.bookitme.com/bookitme-demo-13/tms2.html</span></td></tr>                         
                <tr><td colspan="2"><div style="margin-top:10px;"></div></td></tr>

                <tr><td colspan="2"><div style="margin-top:10px;"><h1>TIMELINE default values:</h1></div></td></tr>
                <th scope="row">Display size <strong>WIDTH :</strong></th>
                <td><input type="text" name="inp_timeline_width" value="' . $this->options['inp_timeline_width'] . '" /> <span style="font-style:italic;padding:10px;">default : 700px</span></td>
                <tr><td scope="row">Display size <strong>HEIGHT :</strong></td>
                    <td><input type="text" name="inp_timeline_height" value="' . $this->options['inp_timeline_height'] . '" /> <span style="font-style:italic;padding:10px;">default : 500px</span></td></tr>         
                <tr><td scope="row">Calendar <strong>URL :</strong></td>
                    <td><input type="text" name="inp_timeline_url" size="60" value="' . $this->options['inp_timeline_url'] . '" /> <span style="font-style:italic;padding:10px;">default : http://www.bookitme.com/tms-time-13/index.php</span></td></tr>                         
                <tr><td colspan="2"><div style="margin-top:10px;"></div></td></tr>
              </table>  
                <input type="submit" name="update_bookitme_options" value="submit" /> 
        </form></div>
        ';

        echo $form;
    }

}

$mybackuper = &new Bookitme();
?>
