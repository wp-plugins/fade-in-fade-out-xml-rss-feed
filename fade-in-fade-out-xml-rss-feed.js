/**
 *     Fade in fade out xml rss feed
 *     Copyright (C) 2011 - 2013 www.gopiplus.com
 *     http://www.gopiplus.com/work/2011/04/29/wordpress-plugin-fade-in-fade-out-xml-rss-feed/
 * 
 *     This program is free software: you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License as published by
 *     the Free Software Foundation, either version 3 of the License, or
 *     (at your option) any later version.
 * 
 *     This program is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *     GNU General Public License for more details.
 * 
 *     You should have received a copy of the GNU General Public License
 *     along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

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