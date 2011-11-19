

var FIFOXMLRSSFEED_FadeInterval;

window.onload = FIFOXMLRSSFEED_FadeRotatess

var FIFOXMLRSSFEED_Links;
var FIFOXMLRSSFEED_Titles;
var FIFOXMLRSSFEED_Cursor = 0;
var FIFOXMLRSSFEED_Max;

function FIFOXMLRSSFEED_FadeRotatess() 
{
	setTimeout("FIFOXMLRSSFEED_FadeRotate()", 5000);
} 

function FIFOXMLRSSFEED_FadeRotate() 
{
  FIFOXMLRSSFEED_FadeInterval = setInterval(FIFOXMLRSSFEED_Ontimer, 10);
  FIFOXMLRSSFEED_Links = new Array();
  FIFOXMLRSSFEED_Titles = new Array();
  FIFOXMLRSSFEED_SetFadeLinks();
  FIFOXMLRSSFEED_Max = FIFOXMLRSSFEED_Links.length-1;
  FIFOXMLRSSFEED_SetFadeLink();
}

function FIFOXMLRSSFEED_SetFadeLink() {
  var ilink = document.getElementById("FIFOXMLRSSFEED_Link");
  ilink.innerHTML = FIFOXMLRSSFEED_Titles[FIFOXMLRSSFEED_Cursor];
  ilink.href = FIFOXMLRSSFEED_Links[FIFOXMLRSSFEED_Cursor];
}

function FIFOXMLRSSFEED_Ontimer() {
  if (FIFOXMLRSSFEED_bFadeOutt) {
    FIFOXMLRSSFEED_Fade+=FIFOXMLRSSFEED_FadeStep;
    if (FIFOXMLRSSFEED_Fade>FIFOXMLRSSFEED_FadeOut) {
      FIFOXMLRSSFEED_Cursor++;
      if (FIFOXMLRSSFEED_Cursor>FIFOXMLRSSFEED_Max)
        FIFOXMLRSSFEED_Cursor=0;
      FIFOXMLRSSFEED_SetFadeLink();
      FIFOXMLRSSFEED_bFadeOutt = false;
    }
  } else {
    FIFOXMLRSSFEED_Fade-=FIFOXMLRSSFEED_FadeStep;
    if (FIFOXMLRSSFEED_Fade<FIFOXMLRSSFEED_FadeIn) {
      clearInterval(FIFOXMLRSSFEED_FadeInterval);
      setTimeout(Faderesume, FIFOXMLRSSFEED_FadeWait);
      FIFOXMLRSSFEED_bFadeOutt=true;
    }
  }
  var ilink = document.getElementById("FIFOXMLRSSFEED_Link");
  if ((FIFOXMLRSSFEED_Fade<FIFOXMLRSSFEED_FadeOut)&&(FIFOXMLRSSFEED_Fade>FIFOXMLRSSFEED_FadeIn))
    ilink.style.color = "#" + ToHex(FIFOXMLRSSFEED_Fade);
}

function Faderesume() {
  FIFOXMLRSSFEED_FadeInterval = setInterval(FIFOXMLRSSFEED_Ontimer, 10);
}

function ToHex(strValue) 
{
  try 
  {
    var result= (parseInt(strValue).toString(16));

    while (result.length !=2)
            result= ("0" +result);
    result = result + result + result;
	
    return result.toUpperCase();
  }
  catch(e)
  {
	  
  }
}