<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Layout - footer.
 * This layout is baed on a moodle site index.php file but has been adapted to show news items in a different
 * way.
 *
 * @package   theme_snap
 * @copyright Copyright (c) 2015 Blackboard Inc. (http://www.blackboard.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

global $USER, $DB;

// If we're on a 'mod' page, retrieve the mod object and check it's completion state in order to conditionally
// pop a completion modal and show a link to the next activity in the footer.
// Some mods should auto pop on completion, and some should display a link.
echo  html_writer::start_div('completion-region');

$renderer = $PAGE->get_renderer('theme_cass');
echo $renderer->render_completion_footer(
        $this->page->theme->settings->nextactivityinfooter,
        $this->page->theme->settings->nextactivitymodaldialog,
        $this->page->theme->settings->nextactivitymodaldialogtolerance
);

echo html_writer::end_div();

$inccoursefooterclass = ($PAGE->theme->settings->coursefootertoggle && strpos($PAGE->pagetype, 'course-view-') === 0) ? ' hascoursefooter' : ' nocoursefooter';
?>

<footer id="moodle-footer" role="contentinfo" class="clearfix">
<?php
/* Snap custom footer.*/
/* Custom footer edit buttons. */
$footnote = empty($PAGE->theme->settings->footnote) ? '' : $PAGE->theme->settings->footnote;
$footnote = format_text($footnote, FORMAT_HTML, ['noclean' => true]);

if ($this->page->user_is_editing() && $PAGE->pagetype == 'site-index') {
    $url = new moodle_url('/admin/settings.php', ['section' => 'themesettingsnap'], 'admin-footnote');
    $link = html_writer::link($url, get_string('editcustomfooter', 'theme_snap'), ['class' => 'btn btn-primary btn-sm']);
    $footnote .= '<p class="text-right">'.$link.'</p>';
}

$custommenu = $OUTPUT->custom_menu();
if (!empty($custommenu) && $this->page->user_is_editing() && $PAGE->pagetype == 'site-index') {
    $url = new moodle_url('/admin/settings.php', ['section' => 'themesettings'], 'id_s__custommenuitems');
    $link = html_writer::link($url, get_string('editcustommenu', 'theme_snap'), ['class' => 'btn btn-primary btn-sm']);
    $custommenu .= '<p class="text-right">'.$link.'</p>';
}


/* Snap main footer. */
echo '<div id="snap-site-footer">';
if (!empty($footnote)) {
    echo '<div id="snap-footer-content">';
    echo $footnote;
    echo '</div>';
}
/* Social media links. */
$socialmedialinks = '';
if (!empty($PAGE->theme->settings->facebook)) {
    $socialmedialinks .= $this->social_menu_link('facebook', $PAGE->theme->settings->facebook);
}
if (!empty($PAGE->theme->settings->twitter)) {
    $socialmedialinks .= $this->social_menu_link('twitter', $PAGE->theme->settings->twitter);
}
if (!empty($PAGE->theme->settings->linkedin)) {
    $socialmedialinks .= $this->social_menu_link('linkedin', $PAGE->theme->settings->linkedin);
}
if (!empty($PAGE->theme->settings->youtube)) {
    $socialmedialinks .= $this->social_menu_link('youtube', $PAGE->theme->settings->youtube);
}
if (!empty($PAGE->theme->settings->instagram)) {
    $socialmedialinks .= $this->social_menu_link('instagram', $PAGE->theme->settings->instagram);
}
if (!empty($socialmedialinks)) {
    echo '<div id="snap-socialmedia-links">' .$socialmedialinks. '</div>';
}
echo '</div>';
?>


<?php
/* Moodle custom menu. */
if (!empty($custommenu)) {
    echo '<div id="moodle-custom-menu"><br>';
    echo $custommenu;
    echo '</div>';
}

$poweredbyrunby = get_string('poweredbyrunby', 'theme_snap');

if (empty($PAGE->theme->settings->copyrightnotice)) {
    echo '<div class="row">
    <div id="mrooms-footer" class="helplink col-sm-6">
        <small>';
    if ($OUTPUT->page_doc_link()) {
        echo $OUTPUT->page_doc_link();
        echo "<br>";
    }
    echo '<br/>' . $poweredbyrunby . '
    </small>
    </div>';
} else {
    echo $PAGE->theme->settings->copyrightnotice;
}
?>
    <div class="langmenu col-sm-6 text-right">
        <?php echo $OUTPUT->lang_menu(); ?>
    </div>
</div>

<div id="page-footer">
<br/>
<?php echo $OUTPUT->standard_footer_html(); ?>
</div>
</footer>
<?php echo $OUTPUT->standard_end_of_body_html() ?>
<!-- bye! -->
</body>
</html>
