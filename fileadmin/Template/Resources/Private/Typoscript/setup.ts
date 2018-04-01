page = PAGE
config.contentObjectExceptionHandler = 0
config {
  prefixLocalAnchors = all
  noPageTitle = 1
  simulateStaticDocuments = 0
  tx_realurl_enable = 0
  language = de
  locale_all = de_DE
  index_enable = 1
  index_externals = 1
  sys_language_uid = 0
  baseURL = https://relaunch.fachverband-fernmeldebau.de/
  doctype = xhtml_trans
  
  concatenateJs = 1
  concatenateCss = 0

  compressJs = 1
  compressCss = 0
}

plugin.tx_indexedsearch.blind.lang=-1
plugin.tx_indexedsearch._DEFAULT_PI_VARS.lang = 0
plugin.tx_indexedsearch.searchUID = 23

plugin.tx_ffbinterndl_pi2._LOCAL_LANG.de {
  pi_list_browseresults_prev = < Zurück
  pi_list_browseresults_page = Seite
  pi_list_browseresults_next = Nächste >
  pi_list_browseresults_first = << Erste
  pi_list_browseresults_last = Letzte >>
  pi_list_browseresults_displays = ###SPAN_BEGIN###%s bis %s Einträge von insgesamt ###SPAN_BEGIN###%s
  pi_list_browseresults_displays_advanced = Von ###FROM### bis ###TO### Einträge von insgesamt ###OUT_OF###
  pi_list_browseresults_to = zu
}

config.disablePrefixComment = true
lib.parseFunc_RTE.nonTypoTagStdWrap.encapsLines.addAttributes.P.class >
tt_content.stdWrap.innerWrap >
#tt_content.stdWrap.dataWrap >

# POWERMAIL
# ****************************************************
plugin.tx_powermail.settings.setup.spamshield._enable = 0

plugin.tx_powermail {
        view {
                templateRootPaths {
                        0 = EXT:powermail/Resources/Private/Templates/
                        1 = fileadmin/template/powermail/Templates/
                }
                partialRootPaths {
                        0 = EXT:powermail/Resources/Private/Partials/
                        1 = fileadmin/template/powermail/Partials/
                }
                layoutRootPaths {
                        0 = EXT:powermail/Resources/Private/Layouts/
                        1 = fileadmin/template/powermail/Layouts/
                }
        }
}

page.meta {
  Viewport = width=device-width, initial-scale=1
}

page.includeCSS {
  bootstrap = https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css
  bootstrap.external = 1

  file10 = fileadmin/template/css/screen.css
  file10.media = screen
}


page.headerData = COA

page.headerData.5 = TEXT
page.headerData.5.value (
<!--[if IE]>
  <link rel="stylesheet" type="text/css" href="/fileadmin/template/css/ie-only.css" />
<![endif]-->
)

page.headerData.10 = TEXT
page.headerData.10.value = <meta name="google-site-verification" content="c8eC4rpTKUJ_161mqxiWwbaJ5gNdWDDV0I3vFd4QbZM" />

page.headerData.15 = TEXT
page.headerData.15.value = <meta name="robots" content="NOODP" />

page.headerData.25 = TEXT
page.headerData.25.field = subtitle // title
page.headerData.25.wrap = <title> |&nbsp;&#124; Fachverband Fernmeldebau e.V.&nbsp;&#124; FFB</title>

page.headerData.30 = TEXT
page.headerData.30.value (
<script>
var gaProperty = 'UA-23016475-1';
var disableStr = 'ga-disable-' + gaProperty;
if (document.cookie.indexOf(disableStr + '=true') > -1) {
        window[disableStr] = true;
}
function gaOptout() {
        document.cookie = disableStr + '=true; expires=Thu, 31 Dec 2099 23:59:59 UTC; path=/';
        window[disableStr] = true;
        alert('Das Tracking durch Google Analytics wurde in Ihrem Browser für diese Website deaktiviert.');
}
</script>
<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
ga('create', 'UA-18906908-1', 'auto');
ga('set', 'anonymizeIp', true);
ga('send', 'pageview');
</script>
 )
page.shortcutIcon = fileadmin/template/media/favicon.png

page.meta.keywords.data = DB:pages:1:keywords
page.meta.keywords.override.field = keywords

page.meta.description.data = DB:pages:1:description
page.meta.description.override.field = description

page.meta.abstract.data = DB:pages:1:abstract
page.meta.abstract.override.field = abstract

page.includeJSFooterlibs.powermailJQuery >
page.includeJSFooterlibs.powermailJQueryUi >
page.includeJSFooterlibs.powermailJQueryUiDatepicker >
page.includeJSFooterlibs >
page.includeJSFooter >
page.includeJSlibs.jquery >

page.includeJSlibs {
  powermail_jQuery >
  powermail_jQueryTools >
  powermail_jQueryToolsTabs >
  powermailJQuery >
  powermailJQueryUi >
  powermailJQueryUiDatepicker >
}

page.footerData.12 = TEXT
#page.footerData.12.value = <script src="https://code.jquery.com/jquery-1.8.0.min.js" type="text/javascript"></script>
page.footerData.12.value = <script type="text/javascript" src="https://code.jquery.com/jquery-latest.min.js"></script>
page.footerData.15 = TEXT
page.footerData.15.value = <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js" type="text/javascript"></script>
page.footerData.16 = TEXT
page.footerData.16.value = <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
page.footerData.19 = TEXT
page.footerData.19.value = <script src="/fileadmin/template/js/plugins/textChange.js" type="text/javascript"></script>
page.footerData.20 = TEXT
page.footerData.20.value = <script src="/fileadmin/template/js/site.js" type="text/javascript"></script>


plugin.tx_staticinfotables_pi1 {
  languageCode = DE
  countryCode = DEU
  countryZoneCode = NRW
}

plugin.tx_newloginbox_pi1.templateFile = fileadmin/template/newloginbox_template.html

plugin.tx_newloginbox_pi1 {
  email_from = [email]ffb@fachverband-fernmeldebau.de[/email]
  email_fromName = Fachverband Fernmeldebau
  replyTo = [email]ffb@fachverband-fernmeldebau.de[/email]
  _LOCAL_LANG.default.forgot_password_pswmsg (
  Your password
  Dear %s
  
  As you requested, here is your forgotten password:
  Your username is &quot;%s&quot;
  Your password is &quot;%s&quot;
  
  Feel free to contact us with any questions or comments.
  )
  _LOCAL_LANG.de{
    forgot_password_enterEmail (
    Bitte geben Sie die Email-Adresse ein, mit der Sie sich registriert haben.
    Anschließend klicken Sie auf "Daten senden" und das Passwort / Login wird Ihnen umgehend zugesendet.
    Achten Sie bitte auf die korrekte Schreibweise Ihrer Email-Adresse.
    )
    forgot_password = Username oder Passwort vergessen?
    send_password = Daten senden
  }
}


# INDEXED SEARCH ANWERFEN UND KONFIGURIEREN
# ****************************************************
plugin.tx_indexedsearch._DEFAULT_PI_VARS.lang = 0

plugin.tx_macinasearchbox_pi1 {
  pidSearchpage = 23
  templateFile = fileadmin/template/indexed_search_template.htm
}
plugin.tx_indexedsearch.templateFile = fileadmin/template/indexed_search_ergebnis_template.html


plugin.tt_news {

  templateFile = fileadmin/template/tt_news_template.html
  pid_list = 3
  code = LATEST
  latestLimit = 1
  archiveTypoLink.parameter = 18
  singlePid = 2
  excludeAlreadyDisplayedNews = 0
  displayLatest.date_stdWrap{
    wrap = <p><strong><img src="fileadmin/template/media/icon_news.png" alt="" align="left" />|</strong></p>
    
  }
 displayLatest.title_stdWrap {
   append =  TEXT
   append.fieldRequired = short
   append.field= short
   append.wrap = <p>|</p>
 }
  displayLatest.content_stdWrap {
    crop = 300 | ...  | 1
    wrap = <p>|
    append = TEXT
    append.data = register:newsMoreLink
    append.wrap = &nbsp;&gt;&nbsp; |</p>
  }
  
  _LOCAL_LANG.de{
    more = Details
    textFiles = Downloads
    goToArchive = Newsarchiv
  }

}


page.10 = TEMPLATE

page.10 {

   template = FILE

   template.file =  fileadmin/template/template_1spaltig.html

   workOnSubpart = DOCUMENT_BODY
  
   subparts.INHALTOBEN < styles.content.get
  #subparts.INHALTOBEN.renderObj =< tt_content
   subparts.INHALTOBEN.renderObj.stdWrap {
    wrap = <div class="content_element"> | </div>
    if.isTrue.numRows < styles.content.get
  }
  
   subparts.INHALTLINKS < styles.content.getLeft  

  ## Wrap nur wenn nicht leer
  subparts.INHALTLINKS.stdWrap {
    wrap = <div class="content_element_spalte-links"> | </div>
    if.isTrue.numRows < styles.content.getLeft
  }
  
  subparts.INHALTRECHTS <  styles.content.getRight
  ## Wrap nur wenn nicht leer
  subparts.INHALTRECHTS.stdWrap {
    wrap = <div class="content_element_spalte-rechts"> | </div>
    if.isTrue.numRows <  styles.content.getRight
  }
   
  subparts.NEWS = COA
  subparts.NEWS.10 < plugin.tt_news
  subparts.NEWS.20 < styles.content.getRight
  
  subparts.SUCHE < plugin.tx_macinasearchbox_pi1
  
   subparts.SEITENTITEL = COA
   subparts.SEITENTITEL {
     10 = TEXT
     10.field = title
     10.wrap = <h1> | </h1>
   }
   marks.HULLLOGO >
   marks.HULLLOGO = COA
   marks.HULLLOGO.10 = TEXT
   marks.HULLLOGO.10.data = levelmedia:-1, slide
   marks.HULLLOGO.10.listNum = 0
   marks.HULLLOGO.10.wrap = style="background: url('uploads/media/|') 10px 42px no-repeat;"
  
  // 6.2
   marks.HULLLOGO >
   marks.HULLLOGO = COA
   marks.HULLLOGO {
     10 = IMG_RESOURCE
     10 {
       file {
           import.data = levelmedia:-1, slide
           treatIdAsReference = 1
           import.listNum = 0
       }
       stdWrap.wrap = style="background-image: url('|');"
     }
  }
  
  marks.RECHTSHEADER = TEXT
  marks.RECHTSHEADER.value = News
  
  marks.SUBTITLE >
  marks.SUBTITLE = COA
  marks.SUBTITLE.10 = TEXT
  marks.SUBTITLE.10.data = levelfield:1, subtitle, slide
  
  subparts.FOOTER_SITEMAP = HMENU
  subparts.FOOTER_SITEMAP {
    special.value = 0
       1 = TMENU
       1 {
         expAll = 1
         wrap = <ul>|</ul>
         NO = 1
         NO {
           linkWrap = <li>|</li>
         }
         IFSUB = 1
         IFSUB {
           wrapItemAndSub = <li>|</li>
         }
     }
     2 = TMENU
     2 {
       expAll = 1
       wrap = <ul>|</ul>
       NO = 1
       NO {
         linkWrap = <li>|</li>
       }
       IFSUB = 1
       IFSUB {
         wrapItemAndSub = <li>|</li>
       }
     }
    3 < .2
   }
  /* ---------------------------------------------------------------
 * Twitter bootstrap style navbar dropdown (with responsive mode)
 */
subparts.NAVIGATION = COA
subparts.NAVIGATION.wrap = |
subparts.NAVIGATION {

    # Responsive Navbar Part 1
    10 = TEXT
    10 {
        # fontawesome
        # value = <span class="fa fa-bars"></span>
        # glyphicon from bootstrap
        value = <span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
        wrap = <div class="navbar-header"><button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#mainnavbar">|</button></div>
    }

    # Responsive Navbar Part 2: Place all navbar contents you want collapsed withing .navbar-collapse.collapse.
    20 = HMENU
    20.wrap = <div class="collapse navbar-collapse" id="mainnavbar"><ul class="nav navbar-nav">|</ul><ul class="nav navbar-nav "><li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-search"></i></a><ul class="dropdown-menu" style="padding:12px;"><form class="form-inline" action="suche/" method="post"><div class="input-group"><input name="tx_indexedsearch[sword]" type="text" class="form-control" placeholder="Suche..."><input type="hidden" name="tx_indexedsearch[_sections]" value="0" /><input type="hidden" name="tx_indexedsearch[pointer]" value="0" /><input type="hidden" name="tx_indexedsearch[ext]" value="0" /><input type="hidden" name="tx_indexedsearch[lang]" value="0" /><span class="input-group-btn"><button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button></span></div></form></ul></li></ul></div>
    20 {
        special.value = 0
        maxItems = 7
        entryLevel = 0
        #excludeUidList = 11,12
        1 = TMENU
        1 {
            wrap = |
            expAll = 1

            NO = 1
            NO.allWrap >
            NO.wrapItemAndSub = <li>|</li>
            CUR = 1
            CUR < .NO
            CUR.wrapItemAndSub = <li class="active">|</li>
            ACT = 1
            ACT < .CUR

            # Dropdown menu
            IFSUB = 1
            IFSUB < .NO
            IFSUB.wrapItemAndSub = <li class="dropdown">|</li>
            IFSUB.ATagParams = class="dropdown-toggle" role="button" data-toggle="dropdown" data-target="#"
            IFSUB.ATagBeforeWrap = 1
            IFSUB.stdWrap.wrap = |<b class="caret"></b>
            CURIFSUB = 1
            CURIFSUB < .IFSUB
            CURIFSUB.wrapItemAndSub = <li class="dropdown active">|</li>
            ACTIFSUB = 1
            ACTIFSUB < .CURIFSUB
        }


        2 = TMENU
        2 {
            wrap = <ul class="dropdown-menu  multi-level" role="menu">|</ul>
            expAll = 1

            NO = 1
            NO.allWrap >
            NO.wrapItemAndSub = <li>|</li>
            CUR = 1
            CUR < .NO
            CUR.wrapItemAndSub = <li class="active">|</li>
            ACT = 1
            ACT < .CUR

            IFSUB = 1
            IFSUB < .NO
            IFSUB.wrapItemAndSub = <li class="dropdown-submenu">|</li>
            IFSUB.ATagParams = class="dropdown-toggle" role="button" data-toggle="dropdown" data-target="#"
            IFSUB.ATagBeforeWrap = 1
            IFSUB.stdWrap.wrap = |

            CURIFSUB = 1
            CURIFSUB < .IFSUB
            CURIFSUB.wrapItemAndSub = <li class="dropdown-submenu active">|</li>

            ACTIFSUB = 1
            ACTIFSUB < .CURIFSUB

            SPC = 1
            SPC.doNotLinkIt = 1
            SPC.doNotShowLink = 1
            SPC.allWrap = <li class="divider"></li>
        }

        # no submenus anymore
        2.IFSUB >
        2.CURIFSUB >
        2.ACTIFSUB >
      
        3 = TMENU
        3 {
            wrap = <ul class="dropdown-menu" role="menu">|</ul>
            expAll = 1

            NO = 1
            NO.allWrap >
            NO.wrapItemAndSub = <li>|</li>
            CUR = 1
            CUR < .NO
            CUR.wrapItemAndSub = <li class="active">|</li>
            ACT = 1
            ACT < .CUR

            IFUSB < .1.IFSUB
            CURIFSUB < .1.CURIFSUB
            ACTIFSUB < .1.ACTIFSUB

            SPC = 1
            SPC.doNotLinkIt = 1
            SPC.doNotShowLink = 1
            SPC.allWrap = <li class="divider"></li>
        }

        4 < .3
        # no submenus anymore
        4.IFSUB >
        4.CURIFSUB >
        4.ACTIFSUB >
    }
}
/*
  subparts.NAVIGATION = HMENU
   subparts.NAVIGATION {
    special.value = 0
    maxItems = 7
       1 = TMENU
       1 {
         expAll = 1
         wrap = <ul id="nav">|</ul>
         NO = 1
         NO {
           linkWrap = <li>|</li>
         }
         IFSUB = 1
         IFSUB {
           wrapItemAndSub = <li>|</li>
         }
         ACT = 0
         ACT < .NO
         ACT < .IFSUB
         ACT.ATagParams=class="current"
     }
     2 = TMENU
     2 {
       expAll = 1
       wrap = <ul id="nav">|</ul>
       NO = 1
       NO {
         linkWrap = <li>|</li>
       }
       IFSUB = 1
       IFSUB {
         wrapItemAndSub = <li>|</li>
       }

       wrap = <ul> | </ul>
       IFSUB {
         ATagParams = class="daddy"
       }
     }
     3 < .2
   }
*/

}
  [globalVar=TSFE:page|layout=1]
  page.10.template.file= fileadmin/template/template_2spaltig.html
  [global]


[globalVar = TSFE:id=16]
  page.10.subparts.NEWS < styles.content.getRight
  page.10.marks.RECHTSHEADER.value = Liste filtern nach:
  page.10.subparts.INHALTOBEN >
  page.10.subparts.INHALTOBEN = COA
  page.10.subparts.INHALTOBEN {
    10 < styles.content.get
    10.select.max = 1
    10.renderObj.stdWrap {
      wrap = <div class="content_element"> | </div>
      if.isTrue.numRows < styles.content.get
    }
    20 < styles.content.get
    20.select.begin = 1
  }
[global]


[globalVar = TSFE:id=5]
  page.10.subparts.INHALTOBEN >
  page.10.subparts.INHALTOBEN = COA
  page.10.subparts.INHALTOBEN {
    10 < styles.content.get
    10.select.max = 2
    10.renderObj.stdWrap {
      wrap = <div class="content_element"> | </div>
      if.isTrue.numRows < styles.content.get
    }
    20 < styles.content.get
    20.select.begin = 2
  }
[global]

[globalVar = TSFE:id=25,23]
config.index_enable=0
[global]
 
plugin.tx_indexedsearch._CSS_DEFAULT_STYLE = .tx-indexedsearch .tx-indexedsearch-browsebox LI { display:inline; margin-right:5px; }     .tx-indexedsearch .tx-indexedsearch-searchbox INPUT.tx-indexedsearch-searchbox-button { width:100px; }     .tx-indexedsearch .tx-indexedsearch-searchbox INPUT.tx-indexedsearch-searchbox-sword { width:150px; }     .tx-indexedsearch .tx-indexedsearch-whatis { margin-top:10px; margin-bottom:5px; }     .tx-indexedsearch .tx-indexedsearch-whatis .tx-indexedsearch-sw { font-weight:bold; font-style:italic; }     .tx-indexedsearch .tx-indexedsearch-noresults { text-align:center; font-weight:bold; }     .tx-indexedsearch .tx-indexedsearch-res TD.tx-indexedsearch-descr { font-style:italic; }     .tx-indexedsearch .tx-indexedsearch-res .tx-indexedsearch-descr .tx-indexedsearch-redMarkup { color:red; }     .tx-indexedsearch .tx-indexedsearch-res .tx-indexedsearch-info { background:#eeeeee; }     .tx-indexedsearch .tx-indexedsearch-res .tx-indexedsearch-secHead { margin-top:20px; margin-bottom:5px; }     .tx-indexedsearch .tx-indexedsearch-res .tx-indexedsearch-secHead H2 { margin-top:0px; margin-bottom:0px; }     .tx-indexedsearch .tx-indexedsearch-res .tx-indexedsearch-secHead TD { background:#cccccc; vertical-align:middle; }     .tx-indexedsearch .tx-indexedsearch-res .noResume { color:#666666; }     .tx-indexedsearch .tx-indexedsearch-category { background:#cccccc; font-size:16px; font-weight:bold; }      /* Additional styles, needed for the tableless template_css.tmpl (styles don't conflict with the original template) */     .tx-indexedsearch .res-tmpl-css { clear:both; margin-bottom:1em; }     .tx-indexedsearch .searchbox-tmpl-css LABEL { margin-right:1em; width:10em; float:left; }     .tx-indexedsearch .result-count-tmpl-css, .tx-indexedsearch .percent-tmpl-css { letter-spacing:0; font-weight:normal; margin-top:-1.2em; float:right; }     .tx-indexedsearch .info-tmpl-css dt, .tx-indexedsearch dl.info-tmpl-css dd { float:left; }     .tx-indexedsearch .info-tmpl-css dd.item-mtime { float:none; }     .tx-indexedsearch .info-tmpl-css dd.item-path { float:none; }
plugin.tx_indexedsearch.topBrowserWrap = <div class="tx-indexedsearch-browsebox">|</div>