// adding actionscript to a sprite...
<?
// some typical movie variables
Ming_setScale(20.00000000);
ming_useswfversion(6);
$movie=new SWFMovie();
$movie->setDimension(550,400);
$movie->setBackground(0xcc,0xcc,0xcc);
$movie->setRate(12); 

// drawing a red square shape with border (registration point : centered)
$squareshape=new SWFShape(); 
$squareshape->setLine(1,0,0,0); 
$squareshape->setRightFill(255,0,0);
$squareshape->movePenTo(-50,-50); 
$squareshape->drawLine(100,0);  
$squareshape->drawLine(0,100); 
$squareshape->drawLine(-100,0); 
$squareshape->drawLine(0,-100); 

// create a sprite and add red square to it
$squaresprite= new SWFSprite();
$f1 = $squaresprite->add($squareshape);
$squaresprite->nextFrame();

// add red square sprite to movie and move to _x=100 _y=100
// and give it an instance name
$squareclip=$movie->add($squaresprite);
$squareclip->moveTo(100,100);
$squareclip->setName("redsquaremc");

// add actionscript to control sprite
$strAction="
redsquaremc.onEnterFrame=function(){
this._rotation+=5;
};
";

// add actionscript to movie
$movie->add(new SWFAction(str_replace("\r", "", $strAction)));

// save movie
$movie->save("squareccborderspriteactions.swf");
?>
