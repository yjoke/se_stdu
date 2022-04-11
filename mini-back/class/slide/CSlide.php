<?php
class CSlide {

    // SlideUrl->set, get, echo
    function setSlideUrl($slideUrl) {
        $this->slideUrl = $slideUrl;
    }
    function getSlideUrl() {
        return $this->slideUrl;
    }
    function echoSlideUrl() {
        echo "\"slideUrl\": \"".$this->slideUrl."\"";
    }

    // SlideLink->set, get, echo
    function setSlideLink($slideLink) {
        $this->slideLink = $slideLink;
    }
    function getSlideLink() {
        return $this->slideLink;
    }
    function echoSlideLink() {
        echo "\"slideLink\": \"".$this->slideLink."\"";
    }

    // echo->all
    function echoSlide() {
        echo "{";
        $this->echoSlideUrl();
        echo ",";
        $this->echoSlideLink();
        echo "}";
    }

    // virrible
    private $slideUrl;
    private $slideLink;

}

?>
