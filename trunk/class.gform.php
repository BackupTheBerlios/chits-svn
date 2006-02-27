<?php
//
//    GAME Form Class
//    Author: Herman Tolentino MD
//    Description:
//

Class GForm {
//
//  Parent class of GAME Form Class
//
    var $container;
    var $form_header;
    var $method;
    var $action;
    var $name;
    var $form_spacing;
    var $form_padding;
    var $row_align;
    var $width;
    var $text;
    var $customstyle;
    var $backgroundcolor;
    var $visible;
    var $author;
    var $version;
    var $formborder;
    var $formbordercolor;

    function gform () {
        // initialize form container
        $this->author = "Herman Tolentino MD";
        $this->version = "0.1";
        $this->container = "";
        $this->form_name = "";
        $this->method = "";
        $this->action = "";
        $this->width = 0;
        $this->customstyle = '';
        $this->form_spacing = 0;
        $this->form_padding = 0;
        $this->backgroundcolor = "#FFFFFF";
        $this->visible = false;
        $this->formborder = "dotted";
        $this->formbordercolor = "#C3C3C3";
    }

    function setFormBorder($borderstyle, $bordercolor) {
        $this->formborder = $borderstyle;
        $this->formbordercolor = $bordercolor;
    }

    function version() {
        return $this->version;
    }

    function author() {
        return $this->author;
    }

    function Hide() {
        $this->visible = true;
    }

    function Show() {
        $this->visible = false;
    }

    function setFormLayout() {
        if (func_num_args()==0) {
            print "SYNTAX: setFormLayout(\$spacing int, \$padding int)";
        } else {
            $arg_list = func_get_args();
            $this->form_spacing = $arg_list[0];
            $this->form_padding = $arg_list[1];
        }
    }

    function setMethod($param) {
        $this->method = $param;
    }

    function setAction($param) {
        $this->action = $param;
    }

    function setName ($param) {
        $this->name = $param;
    }

    function setWidth ($param) {
        $this->width = $param;
    }

    function setValue($param) {
        $this->value = $param;
    }

    function setCustomStyle ($param) {
        $this->customstyle = $param;
    }

    function addBreak() {
        $this->container .= "<tr><td><br></td></tr>\n";
    }

    function addElement($param) {
    //
    // elements are added in consecutive order!
    //
        $this->container .= "<tr><td>".$param."</td></tr>\n";
    }

    function addGroupedElements() {
    //
    // several elements in a row
    //
        if (func_num_args()>0) {
            $args = func_get_args();
            $this->container .= "<tr><td>";
            foreach($args as $key=>$value) {
                $this->container .= $value." ";
            }
            $this->container = trim($this->container);
            $this->container .= "</td></tr>";
        }
    }

    function addHeader($text, $weight, $backgroundcolor) {
        $this->form_header = "<tr bgcolor='".$backgroundcolor."'><td>".($weight=='bold'?'<b>':'').($weight=='bolditalic'?'<b><i>':'').
                        $text.($weight=='bold'?'</b>':'').($weight=='bolditalic'?'</b></i>':'').
                        "<td></tr>\n";
    }

    function addBoxedText($text, $backgroundcolor) {
        $this->container =
            "<tr valign='top'><td>\n".
            "<table width='100%' bgcolor='$backgroundcolor' cellpadding='3' cellspacing='0' style='border: 1px solid black'><tr><td>\n".
            $text.
            "</td></tr></table>\n".
            "<td></tr>\n";
    }

    function setText($param) {
    // sets text within widget
        $this->text = $param;
    }

    //function setLabel($param) {
    // sets label for element
    //    $this->label = $param;
    //}

    function setLabel($label, $borderstyle, $backgroundcolor) {
    //
        $this->label = $label;
        $this->labelborder = $borderstyle;
        $this->labelbackgroundcolor = $backgroundcolor;
    }

    function addText($text, $backgroundcolor) {
    // adds a row of text to the form
        $this->container .= "<tr bgcolor='".$backgroundcolor."'><td>".$text."<td></tr>\n";
    }

    function setBackgroundColor($param) {
        $this->backgroundcolor = $param;
    }

    function display() {
        print "<table width='".$this->width."' bgcolor = '".$this->backgroundcolor."' style='border: 1px ".$this->formborder." ".$this->formbordercolor."; ".$this->customstyle."' cellpadding='".$this->form_padding."' cellspacing='".$this->form_spacing."'>\n".
              $this->form_header.
              "<form name='".$this->form_name."' method='".$this->method."' action='".$this->action."'>\n".
              $this->container.
              "</form></table>\n";
    }

    function load_javascript($jsfile) {
        if (file_exists($jsfile)) {
            print "<script type=\"text/javascript\" src=\"$jsfile\"></script>\n";
        } else {
            print "$file not found.";
        }
    }

    function load_css($cssfile) {
        if (file_exists($cssfile)) {
            print "<link type=\"text/css\" rel=\"StyleSheet\" href=\"$cssfile\" />\n";
        } else {
            print "$file not found.";
        }
    }

}

Class GForm_HiddenVariable extends GForm {
//
//  GForm TextBox Class
//  Author: Herman Tolentino MD
//
    var $name;
    var $text;
    var $width;
    var $ispassword;
    var $cssclass;
    var $customstyle;
    var $label;
    var $widget;

    function GForm_HiddenVariable() {
    }

    function widget() {
        $this->widget = "<input type='hidden' name='".$this->name."' value='".($this->text?$this->text:$this->value)."'>";
        return $this->widget;
    }
}

Class GForm_TextBox extends GForm {
//
//  GForm TextBox Class
//  Author: Herman Tolentino MD
//
    var $name;
    var $text;
    var $width;
    var $ispassword;
    var $cssclass;
    var $customstyle;
    var $label;
    var $widget;
    var $value;

    function GForm_TextBox () {
        $this->text = "";
        $this->width = "25";
        $this->ispassword = false;
        $this->cssclass ="";
        $this->customstyle = "border: 1px solid black";
    }

    function addText($param) {
        $this->text = $param;
    }

    function isPassWord ($param) {
        $this->ispassword = $param;
    }

    function setLabel ($text, $background, $backgroundcolor) {
        //$this->label = "<span class='".$cssclass."'>$text</span>".($location=='top'?'<br>':' ');
        $this->label = "<div style='position: relative; top:-2px; ".($background=="none"?"":"border: 1px dotted black;")." left:0px; ".($backgroundcolor=="none"?"":"background-color: #DCDCDC;")." padding: 0.8px; padding-left: 3px; width: ".(strlen(trim($text))*10)."px;'><b>".trim(strtoupper($text))."</b></div>";
    }

    function widget() {
        if (!empty($this->label)) {
            $this->widget = $this->label."<input type='".($this->ispassword?"password":"text")."' name='".$this->name."' size='".$this->width."' class='".$this->cssclass."' value='".($this->text?$this->text:$this->value)."' style='".$this->customstyle."'>";
        } else {
            $this->widget = "<input type='".($this->ispassword?"password":"text")."' name='".$this->name."' size='".$this->width."' class='".$this->cssclass."' value='".($this->text?$this->text:$this->value)."' style='".$this->customstyle."'>";
        }
        return $this->widget;
    }

}

Class GForm_Button extends GForm {
//
//  GForm Button Class
//  Author: Herman Tolentino MD
//
    var $name;
    var $text;
    var $cssclass;
    var $customstyle;
    var $widget;
    var $color;

    function GForm_Button() {
        $this->cssclass ="";
        $this->customstyle = "border: 1px solid black;";
        $this->color = "lightgrey";
    }

    function setColor($param) {
        $this->color = $param;
    }

    function widget() {
        $this->widget = "<input type='submit' name='".$this->name."' class='".$this->cssclass."' value='".$this->text."' style='".$this->customstyle."background-color: ".$this->color."'>";
        return $this->widget;
    }

}

Class GForm_CheckBox extends GForm {

    var $name;
    var $labelposition;
    var $optionstatus;
    var $grouplabel;

    function GForm_CheckBox() {
        $this->name = "";
        $this->text = "";
        $this->labelposition = "labelright";
        $this->optionstatus = "unchecked";
    }

    function setGroupLabel($param) {
        $this->grouplabel = $param;
    }

    function setName($param) {
        $this->name = $param."[]";
    }

    function addOption($option_text, $label_position, $option_status) {

        $this->labelposition = $label_position;
        $this->text = $option_text;
        $this->optionstatus = $option_status;

        switch ($this->labelposition) {
        case "labelleft":
            $this->widget .= $this->text." <input type='checkbox' name='".$this->name."' ".($this->optionstatus=="checked"?"checked":"")." value='1'><br>";
            break;
        case "labelright":
        default:
            $this->widget .= "<input type='checkbox' name='".$this->name."' ".($this->optionstatus=="checked"?"checked":"")." value='1'> ".$this->text."<br>";
        }
    }

    function widget() {
        $this->widget = $this->grouplabel."<br>".$this->widget;
        return $this->widget;
    }
}

Class GForm_Radio extends GForm {

    var $name;
    var $text;
    var $label;
    var $widget;
    var $group;
    var $layout;
    var $labelborder;
    var $labelbackgroundcolor;

    function GForm_Radio() {
        $this->text = "";
        $this->label = "";
        $this->widget = "";
        $this->group = array();
        $this->layout = "horizontal";
        $this->labelborder = "dotted";
        $this->labelbackgroundcolor = "#C3C3C3";
    }

    function setButtonLayout($param) {
        $this->layout = $param;
    }

    function setLabel($label, $borderstyle, $backgroundcolor) {
    // label for radio group
        $this->label = $label;
        $this->labelborder = $borderstyle;
        $this->labelbackgroundcolor = $backgroundcolor;
    }

    function addChoice($radioname, $labelposition, $radiovalue, $radiotext, $radiostatus) {
        $this->group[] .= "<input type='radio' name='".$radioname."' value='".$radiovalue."' ".($radiostatus=="checked"?"checked":"")."> $radiotext";
    }

    function widget() {
        if (count($this->group)>0) {
            // do not display an empty group
            $labelborder = ($this->labelborder=="none"?"":"border: 1px ".$this->labelborder." ".$this->labelbackgroundcolor.";");
            $labelbackground = ($this->labelbackgroundcolor=="none"?"":"background-color: ".$this->labelbackgroundcolor.";");
            switch ($this->layout) {
            case "vertical":
                $this->widget .= "<div style='position: relative; top:4px; $border left:0px; $labelbackground padding: 0.8px; padding-left: 3px; width: ".(strlen($this->label)*10)."px;'><b>".$this->label."</b></div>";
                $this->widget .= "<table style = 'border: 1px dotted black;' cellpadding='1' cellspacing='0'>";
                foreach($this->group as $key=>$value) {
                    $this->widget .= "<tr><td>$value</td></tr>";
                }
                $this->widget .= "</table>";
                break;
            case "horizontal":
            default:
                $this->widget .= "<div style='position: relative; top:4px; $border left:0px; $labelbackground padding: 0.8px; padding-left: 3px; width: ".(strlen($this->label)*10)."px;'><b>".$this->label."</b></div>";
                $this->widget .= "<table style = 'border: 1px dotted black' cellpadding='4' cellspacing='0'><tr>";
                foreach($this->group as $key=>$value) {
                    $this->widget .= "<td>$value</td>";
                }
                $this->widget .= "</tr></table>";
            }
            return $this->widget;
        }
    }

}

Class GForm_Select extends GForm {

    var $name;
    var $text;
    var $label;
    var $widget;
    var $group;
    var $multiple;
    var $numlines;
    var $refresh;
    var $selectlist;
    var $listdefault;
    var $labelborder;
    var $labelbackgroundcolor;

    function GForm_Select () {
        $this->text = "";
        $this->widget = "";
        $this->selectlist = array();
        $this->labelborder = "dotted";
        $this->labelbackgroundcolor = "#C3C3C3";
    }

    function setList($mylist, $default) {
        $this->selectlist = $mylist;
        $this->listdefault = $default;
    }

    function widget() {
        reset($this->selectlist);
        $labelborder = ($this->labelborder=="none"?"":"border: 1px ".$this->labelborder." ".$this->labelbackgroundcolor.";");
        $labelbackgroundcolor = ($this->labelbackgroundcolor=="none"?"":"background-color: ".$this->labelbackgroundcolor.";");
        $this->widget .= "<div style='position: relative; top:0px; $labelborder left:0px; $labelbackgroundcolor padding: 0.8px; padding-left: 3px; width: ".(strlen($this->label)*10)."px;'><b>".strtoupper($this->label)."</b></div>";
        $this->widget .= "<select name='".$this->name."'>";
        while (list($index, $array) = each($this->selectlist)) {
            list($key, $value) = each($array);
            $this->widget .= "<option value='".$key."'>".$value."</option>";
        }
        $this->widget .= "</select>";
        return $this->widget;
    }

}

Class GForm_TextArea {

    var $name;
    var $text;
    var $label;
    var $widget;
    var $group;
    var $columns;
    var $rows;
    var $refresh;
    var $labelborder;
    var $labelbackgroundcolor;

    function GForm_Select () {
        $this->text = "";
        $this->widget = "";
        $this->labelborder = "dotted";
        $this->labelbackgroundcolor = "#C3C3C3";
    }

    function setList($mylist, $default) {
        $this->selectlist = $mylist;
        $this->listdefault = $default;
    }

    function widget() {
        reset($this->selectlist);
        $labelborder = ($this->labelborder=="none"?"":"border: 1px ".$this->labelborder." ".$this->labelbackgroundcolor.";");
        $labelbackgroundcolor = ($this->labelbackgroundcolor=="none"?"":"background-color: ".$this->labelbackgroundcolor.";");
        $this->widget .= "<div style='position: relative; top:0px; $labelborder left:0px; $labelbackgroundcolor padding: 0.8px; padding-left: 3px; width: ".(strlen($this->label)*10)."px;'><b>".strtoupper($this->label)."</b></div>";
        $this->widget .= "<select name='".$this->name."'>";
        while (list($index, $array) = each($this->selectlist)) {
            list($key, $value) = each($array);
            $this->widget .= "<option value='".$key."'>".$value."</option>";
        }
        $this->widget .= "</select>";
        return $this->widget;
    }

}

Class GForm_Slider {
//
// This class makes use of WebFX components by Eric Arvidsson and Emil A Eklund.
// Source: http://webfx.eae.net/
// License: GPL
//
// Important: Make sure you have all javascript page included in the head section.
// See info/index.php and use GForm::load_javascript and GForm::load_css functions.
//

    var $widget;

    function GForm_Slider() {
    }

    function widget() {
        $this->widget .= "<input size = '5' type='text' name='' value='' style='border: 1px solid black;'></div>".
            "<div class='slider' style ='position: relative; top:-1.8em; left:5em;' id='slider-2' tabIndex='1'>".
            "<input class='slider-input' id='slider-input-2' name='slider-input-2'/>".
            "</div>".
            "".
            "<script type=\"text/javascript\">".
            "var s = new Slider(document.getElementById(\"slider-2\"),".
            "document.getElementById(\"slider-input-2\"));".
            "</script>";
        return $this->widget;
    }
}

Class GForm_DatePicker {
}

?>