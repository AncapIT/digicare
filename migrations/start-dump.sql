SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


DROP TABLE IF EXISTS `cl_1_documents`;
CREATE TABLE IF NOT EXISTS `cl_1_documents` (
  `doc_id` int(11) NOT NULL AUTO_INCREMENT,
  `doc_title` varchar(500) NOT NULL,
  `user_id` int(15) NOT NULL DEFAULT '0',
  `category_desc` varchar(1) NOT NULL DEFAULT 'n',
  `doc_header` varchar(500) NOT NULL,
  `doc_type` varchar(100) NOT NULL,
  `doc_date` datetime DEFAULT NULL,
  `doc_content` text NOT NULL,
  `doc_options` varchar(500) NOT NULL,
  `doc_image` varchar(100) NOT NULL,
  `pdf_link` varchar(500) NOT NULL,
  PRIMARY KEY (`doc_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;




INSERT INTO `cl_1_documents` (`doc_id`, `doc_title`, `user_id`, `category_desc`, `doc_header`, `doc_type`, `doc_date`, `doc_content`, `doc_options`, `doc_image`, `pdf_link`) VALUES
(1, 'Diary', 0, 'y', 'Information', 'diary', '0000-00-00 00:00:00', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo conseq</p>\r\n', '', '', ''),
(2, 'About Patient', 2, 'n', '', 'about_patient', '0000-00-00 00:00:00', '<p>Kungen heter Carl Gustaf Folke Hubertus.</p>\r\n\r\n<p>Han blev kung n&auml;r han var 27 &aring;r gammal efter Kung Gustaf den sj&auml;tte Adolf.<br />\r\nEtt valspr&aring;k &auml;r en kort mening p&aring; n&aring;gra f&aring; ord, som talar om vad en person vill och hur personen t&auml;nker. Kungens valspr&aring;k &auml;r F&ouml;r Sverige - i tiden. Med det menar Kungen att han vill arbeta f&ouml;r Sverige p&aring; ett s&auml;tt som passar just v&aring;r tid.<br />\r\nKungen f&ouml;ddes den 30 april 1946. Hans far dog i en flygolycka n&auml;r Kungen var ett &aring;r.</p>\r\n\r\n<p><strong>Kungens utbildning&nbsp;</strong></p>\r\n\r\n<p>Kungen tog studenten 1966. Sedan fick han utbildning i milit&auml;ren, framf&ouml;r allt i flottan, som f&ouml;rsvarar landet med olika fartyg. Kungen var med p&aring; en l&aring;ng resa med fartyget &Auml;lvsnabben. Kungen blev sj&ouml;officer. Efter detta studerade Kungen det svenska samh&auml;llet. Han bes&ouml;kte myndigheter, fabriker och skolor. Han l&auml;rde sig om domstolar, riksdag och regering. Kungen studerade ocks&aring; arbete i andra l&auml;nder. Han var med i Sveriges arbete i FN och i hj&auml;lparbete i Afrika.</p>\r\n\r\n<p><strong>Familj</strong>&nbsp;</p>\r\n\r\n<p>Under OS i M&uuml;nchen 1972 tr&auml;ffade Kungen Silvia. Hon arbetade som v&auml;rdinna p&aring; OS. De f&ouml;rlovade sig p&aring; Stockholms slott 1976 och gifte sig samma &aring;r i Storkyrkan. De har tre barn som heter Victoria, Carl Philip och Madeleine. Victoria kommer att bli drottning, eftersom hon &auml;r &auml;ldst av syskonen. Kungen och Drottningen bodde f&ouml;rst p&aring; Stockholms slott men flyttade sedan till Drottningholms slott.</p>\r\n\r\n<p><strong>Kungens intressen</strong></p>\r\n\r\n<p>Kungen &auml;r mycket intresserad av natur och milj&ouml; och har stora kunskaper om det.&nbsp;Kungen har ordnat m&ouml;ten om milj&ouml; f&ouml;r m&auml;nniskor fr&aring;n hela v&auml;rlden. Han &auml;r ordf&ouml;rande i V&auml;rldsnaturfonden i Sverige, som arbetar f&ouml;r att natur och djur ska finnas kvar. Kungen har alltid varit intresserad av scouterna. Han var sj&auml;lv vargunge och scout och kallades d&aring; Mowgli. Kungen &auml;r ofta med p&aring; olika scoutl&auml;ger och hedersmedlem i scoutf&ouml;rbund.<br />\r\nKungen &auml;r ocks&aring; mycket intresserad av bilar och verktyg. N&auml;r han fyllde fem &aring;r fick han en trampbil, en murslev, tegelstenar och verktyg. Kungen brukar vara med p&aring; Svenska Kungsrallyt p&aring; &Ouml;land. D&aring; k&ouml;r han en gammal Volvo PV 60.<br />\r\nKungen har alltid tyckt om att vara i naturen. Han &auml;r duktig p&aring; att &aring;ka skidor och har &aring;kt Vasaloppet tre g&aring;nger.<br />\r\nP&aring; somrarna k&ouml;r han g&auml;rna sina b&aring;tar. D&aring; arbetar han ocks&aring; i tr&auml;dg&aring;rden p&aring; slottet Solliden p&aring; &Ouml;land. Han gr&auml;ver dammar och arbetar i ekskogen.<br />\r\nKungen &auml;r intresserad av konst, musik och mat. Han har visat sin konstsamling och ordnar konserter p&aring; Stockholms slott.<br />\r\nKungen jagar ocks&aring; varje &aring;r.</p>\r\n', '', '', ''),
(3, 'About Patient', 4, 'n', '', 'about_patient', '0000-00-00 00:00:00', '<p>Kungen heter Carl Gustaf Folke Hubertus.</p>\r\n\r\n<p>Han blev kung n&auml;r han var 27 &aring;r gammal efter Kung Gustaf den sj&auml;tte Adolf.<br />\r\nEtt valspr&aring;k &auml;r en kort mening p&aring; n&aring;gra f&aring; ord, som talar om vad en person vill och hur personen t&auml;nker. Kungens valspr&aring;k &auml;r F&ouml;r Sverige - i tiden. Med det menar Kungen att han vill arbeta f&ouml;r Sverige p&aring; ett s&auml;tt som passar just v&aring;r tid.<br />\r\nKungen f&ouml;ddes den 30 april 1946. Hans far dog i en flygolycka n&auml;r Kungen var ett &aring;r.</p>\r\n\r\n<p><strong>Kungens utbildning&nbsp;</strong></p>\r\n\r\n<p>Kungen tog studenten 1966. Sedan fick han utbildning i milit&auml;ren, framf&ouml;r allt i flottan, som f&ouml;rsvarar landet med olika fartyg. Kungen var med p&aring; en l&aring;ng resa med fartyget &Auml;lvsnabben. Kungen blev sj&ouml;officer. Efter detta studerade Kungen det svenska samh&auml;llet. Han bes&ouml;kte myndigheter, fabriker och skolor. Han l&auml;rde sig om domstolar, riksdag och regering. Kungen studerade ocks&aring; arbete i andra l&auml;nder. Han var med i Sveriges arbete i FN och i hj&auml;lparbete i Afrika.</p>\r\n\r\n<p><strong>Familj</strong>&nbsp;</p>\r\n\r\n<p>Under OS i M&uuml;nchen 1972 tr&auml;ffade Kungen Silvia. Hon arbetade som v&auml;rdinna p&aring; OS. De f&ouml;rlovade sig p&aring; Stockholms slott 1976 och gifte sig samma &aring;r i Storkyrkan. De har tre barn som heter Victoria, Carl Philip och Madeleine. Victoria kommer att bli drottning, eftersom hon &auml;r &auml;ldst av syskonen. Kungen och Drottningen bodde f&ouml;rst p&aring; Stockholms slott men flyttade sedan till Drottningholms slott.</p>\r\n\r\n<p><strong>Kungens intressen</strong></p>\r\n\r\n<p>Kungen &auml;r mycket intresserad av natur och milj&ouml; och har stora kunskaper om det.&nbsp;Kungen har ordnat m&ouml;ten om milj&ouml; f&ouml;r m&auml;nniskor fr&aring;n hela v&auml;rlden. Han &auml;r ordf&ouml;rande i V&auml;rldsnaturfonden i Sverige, som arbetar f&ouml;r att natur och djur ska finnas kvar. Kungen har alltid varit intresserad av scouterna. Han var sj&auml;lv vargunge och scout och kallades d&aring; Mowgli. Kungen &auml;r ofta med p&aring; olika scoutl&auml;ger och hedersmedlem i scoutf&ouml;rbund.<br />\r\nKungen &auml;r ocks&aring; mycket intresserad av bilar och verktyg. N&auml;r han fyllde fem &aring;r fick han en trampbil, en murslev, tegelstenar och verktyg. Kungen brukar vara med p&aring; Svenska Kungsrallyt p&aring; &Ouml;land. D&aring; k&ouml;r han en gammal Volvo PV 60.<br />\r\nKungen har alltid tyckt om att vara i naturen. Han &auml;r duktig p&aring; att &aring;ka skidor och har &aring;kt Vasaloppet tre g&aring;nger.<br />\r\nP&aring; somrarna k&ouml;r han g&auml;rna sina b&aring;tar. D&aring; arbetar han ocks&aring; i tr&auml;dg&aring;rden p&aring; slottet Solliden p&aring; &Ouml;land. Han gr&auml;ver dammar och arbetar i ekskogen.<br />\r\nKungen &auml;r intresserad av konst, musik och mat. Han har visat sin konstsamling och ordnar konserter p&aring; Stockholms slott.<br />\r\nKungen jagar ocks&aring; varje &aring;r.</p>\r\n', '', '', ''),
(4, 'Kalendarium', 0, 'n', 'Veckans planerade händelser', 'calendar', '0000-00-00 00:00:00', '<p><strong>M&aring;ndag</strong></p>\r\n<p>10:00-14:00&nbsp;Cirkelfys, lunch, surfkaf&eacute;</p>\r\n<p>11:00-14:00 Gymnastik, lunch och talbok</p>\r\n<p>14:00-15:00 Matrosorkestern</p>\r\n<p><strong>Tisdag</strong></p>\r\n<p>10:00-15:00 Gummibandsgympa och fr&aring;gesport</p>\r\n<p>12:00-15:00 Lunch och akvarellm&aring;lning</p>\r\n<p><strong>Onsdag</strong></p>\r\n<p>11:00-14:00 Onsdagsunderh&aring;llning p&aring; Baltzar tr&auml;fflokal</p>\r\n<p>13:00-14:00 Stadsarkivet ber&auml;ttar om de von Sydowska morden</p>\r\n<p>14:30-16:00 Bingo!</p>\r\n<p><strong>Torsdag</strong></p>\r\n<p>09:00-14:00&nbsp;Cirkelfys, sopplunch, tr&auml;ffa terapihundarna</p>\r\n<p>12:00-15:00&nbsp;Lunch och filmtajm</p>\r\n<p><strong>Fredag</strong></p>\r\n<p>12:00-14:00&nbsp;Festlunch</p>\r\n<p>13:00-15:00&nbsp;Alls&aring;ng med Lage och frivilliga musiker</p>\r\n<p><strong>L&ouml;rdag<br /></strong></p>\r\n<p>10:00-13:00&nbsp;Ipad-caf&eacute; och lunch</p>\r\n<p>14:00-16:00 V&auml;vstuga</p>\r\n<p><strong>S&ouml;ndag</strong></p>\r\n<p>11:00-14:00&nbsp;Gymnastik, lunch och talbok</p>\r\n<p>13:00-14:00 Bingo</p>', '', '', ''),
(5, 'Genomförandeplan', 4, 'n', '', 'implementation_plan', '0000-00-00 00:00:00', '<div class="page" title="Page 1">\r\n<div class="layoutArea">\r\n<div class="column">\r\n<p>Genomförandeplan</p>\r\n<p>Exempel på en genomförandeplan som utgår från exempelutredning</p>\r\n<p>1. Lärande och tillämpa kunskap, allmänna uppgifter och krav, kommunikation</p>\r\n<p>Vad ska stödet innehålla:</p>\r\n<p>&bull; Att fatta beslut, stödjande/ tränande insats<br /> &bull; Att genomföra daglig rutin, kompenserande insats<br /> &bull; Att kommunicera genom att ta emot talade meddelanden, stödjande/ tränande insats &bull; Att kommunicera genom att ta emot skrivna meddelanden, kompenserande insats<br /> &bull; Att tala, stödjande/ tränande insats<br /> &bull; Att skriva meddelanden, kompenserande insats</p>\r\n<p>Delmål:</p>\r\n<p>Målet är att Greta ska stödjas i att göra viktiga val under sin dag.<br /> Målet är Greta genom stöttning och påminnelse från personal ska få hjälp med att planera, hantera och fullfölja dagliga rutiner.<br /> Målet är att Greta ska ges möjlighet att träna på att ta emot och hantera muntlig information. Målet är att Greta ska få hjälp med att läsa texter när behov uppstår.<br /> Målet är att Greta ska stimuleras till att prata och berätta.<br /> Målet är att stödja Greta när behov av att uttrycka sig skriftligen uppstår</p>\r\n<p>Hur ska stödet ges:</p>\r\n<p>Att fatta beslut - Gör Greta delaktig i vardagens beslut och ge henne stöd genom t.ex. fråga vilka kläder hon vill ha på sig. Håll då fram några plagg och låt Greta välja.</p>\r\n<p>Att genomföra daglig rutin - Greta behöver muntlig och fysisk handräckning i de flesta moment under dagen t.ex. vad gäller mediciner och påklädning. Följ med Greta till t.ex. måltider och de aktiviteter hon önskar gå på.</p>\r\n<p>Att kommunicera genom att ta emot talade och skrivna meddelanden, att skriva meddelanden och att tala - Greta behöver stöd i att samtala, läsa och skriva. Tänk på att ta ett moment i taget och ha ett lugnt bemötande och ett tydligt kroppsspråk. Invänta svar från Greta och bekräfta svaret. Förklara tydligt för Greta vad som kommer att hända. Sitter Greta i rullstolen så tänk på att alltid säga till innan hon ska någonstans, t.ex. &rdquo;Nu kör jag dig till frisören.&rdquo;</p>\r\n<p>Vem utför insatsen:</p>\r\n<p>Samtliga behov - all personal</p>\r\n<p>När ska stödet ges:</p>\r\n<p>Samtliga behov - dygnet runt</p>\r\n<p>Förflyttning, personlig vård och hemliv,</p>\r\n</div>\r\n</div>\r\n<div class="layoutArea">\r\n<div class="column">\r\n<p>2016-09-30</p>\r\n</div>\r\n</div>\r\n</div>\r\n<div class="page" title="Page 2">\r\n<div class="layoutArea">\r\n<div class="column">\r\n<p>Vad ska stödet innehålla:</p>\r\n<ul>\r\n<li>\r\n<p>Att röra sig omkring på olika platser, stödjande/ tränande insats</p>\r\n</li>\r\n<li>\r\n<p>Att ändra grundläggande kroppsställning, stödjande/ tränande insats</p>\r\n</li>\r\n<li>\r\n<p>Att tvätta sig, stödjande/ tränande insats</p>\r\n</li>\r\n<li>\r\n<p>Att sköta toalettbehov, kompenserande insats</p>\r\n</li>\r\n<li>\r\n<p>Att klä sig, stödjande/ tränande insats</p>\r\n</li>\r\n<li>\r\n<p>Att äta, stödjande/ tränande insats</p>\r\n</li>\r\n<li>\r\n<p>Instruktioner från legitimerad personal, mediciner</p>\r\n</li>\r\n<li>\r\n<p>Att tvätta och torka kläder med hushållsapparater, kompenserande insats</p>\r\n</li>\r\n<li>\r\n<p>Att städa bostaden, kompenserande insats</p>\r\n<p>Delmål:</p>\r\n<p>Målet är att Greta ska kunna vara i olika miljöer så som att förflytta sig mellan olika rum på enheten samt i samband med promenader.<br /> Målet är att Greta ska kunna variera sin kroppställning.<br /> Målet är att Greta ska fortsätta sköta sin övre hygien i ansiktet.</p>\r\n<p>Målet är att Greta ska bibehålla förmågan att säga till om hon behöver gå på toaletten samt att sitta på toaletten själv.</p>\r\n<p>Målet är att Greta ska klara av att klä på sig kläder på överkroppen med fysisk guidning från personal. Nedtill behöver hon aktiv hjälp.<br /> Målet är att Greta ska fortsätta att klara att äta själv genom att personal visar hur man börjar när man ska äta.</p>\r\n<p>Målet med insatsen är att Greta ska få hjälp med måltider.<br /> Målet med insatsen är att Greta ska få hjälp med att tvätta sina kläder. Målet med insatsen är att Greta ska få hjälp med att städa sin bostad.</p>\r\n<p>Hur ska stödet ges:<br /> Hjälpmedel: Rollator, transportrullstol och hygienstol Skyddsåtgärder: Rörelselarm<br /> Medicin: Enligt flik i dokumentationspärm<br /> Nutrition: Enligt flik i dokumentationspärm Inkontinenshjälpmedel: Enligt flik i dokumentationspärm Munvård: Enligt flik i dokumentationspärm</p>\r\n<p>Morgon:</p>\r\n<p>Gå in till Greta när det larmar från rörelselarmet, hon är ofta vaken tidigt. Ge Greta något att dricka samt medicin enligt flik.... på sängkanten. Fråga om Greta vill komma upp eller om hon vill vila en stund.<br /> Hjälp Greta att ställa sig upp och följ henne till toaletten. När Greta går kortare sträckor behöver hon sin rollator samt stöd av en personal som stöttar upp och visar vart hon skall gå.<br /> På toaletten behöver Greta hjälp med att ta på sig strumpor, inkontinensskydd, byxor och skor.</p>\r\n</li>\r\n</ul>\r\n</div>\r\n</div>\r\n<div class="layoutArea">\r\n<div class="column">\r\n<p>2016-09-30</p>\r\n</div>\r\n</div>\r\n</div>\r\n<div class="page" title="Page 3">\r\n<div class="layoutArea">\r\n<div class="column">\r\n<p>Stötta Greta med att försöka tvätta sig på överkroppen själv. Räck Greta tvättlapp och förklara ett moment i taget. Stötta/ hjälp Greta med deodorant, ta på sig tröjan och kamma håret. Ge Greta protesen, hon kan sätta i protesen själv.<br /> Hjälp Greta att ställa sig framför handfatet. Hjälp henne med nedre hygien samt att dra upp byxorna.</p>\r\n<p>Hjälp Greta att sätta sig i transportrullstolen och hjälp Greta till det gemensamma köket på enheten.</p>\r\n<p>Dusch:</p>\r\n<p>Greta har en mobil hygienstol som hon sitter på när hon duschar. Vid dusch behöver Greta hjälp med att tvätta hela kroppen och håret. Greta fryser lätt så låt henne gärna hålla duschen mot kroppen medan hon får hjälp med att tvåla in sig.<br /> Hjälp Greta att torka sig och ta på sig kläder. Hjälp Greta med håret efter duschen.</p>\r\n<p>Se om Greta behöver hjälp med att klippa naglarna.</p>\r\n<p>Måltider:</p>\r\n<p>Greta äter alla måltider i det gemensamma köket på enheten. Hon behöver följas dit. Sitt gärna med henne vid måltider och fika.</p>\r\n<p>Hon behöver hjälp att dela maten och kan ibland ha behov av att man visar henne hur hon skall börja äta. Se flik...... för kostintyg och ev. specialkost<br /> Fråga alltid Greta vad hon vill ha att äta och dricka.<br /> Erbjud Greta fika/ mellanmål under dagen samt innan hon går och lägger sig på kvällen.</p>\r\n<p>Förmiddag och eftermiddag:</p>\r\n<p>Hjälp Greta med toalettbesök. Följ Greta till de aktiviteter hon önskar vara med på. Fråga Greta om hon vill lägga sig och vila efter lunchen.</p>\r\n<p>Kväll:</p>\r\n<p>Fråga Greta när hon vill gå och lägga sig. Hjälp Greta med toalettbesök, ombyte till nattlinne och byte av inkontinensskydd. Be Greta ta ut sin protes och hjälp henne att borsta den. Protesen läggs sedan i en mugg med vatten och corega tablett under natten.<br /> Se flik ...... för eventuella mediciner.</p>\r\n<p>När Greta lagt sig i sängen ska fallmattan läggas nedanför sängen och rörelselarmet skall sättas på.</p>\r\n<p>Natt:</p>\r\n<p>På natten har Greta tillsyner då det larmar från rörelselarmet samt hjälp med toalettbesök och byte av inkontinensskydd.<br /> Greta kan ibland vara orolig och ha svårt att sova och kan då behöva extra tillsyn.</p>\r\n<p>Tvätt:</p>\r\n<p>Greta behöver hjälp med att tvätta sina kläder. Fråga gärna om Greta vill vara med i tvättstugan och hjälpa till.</p>\r\n</div>\r\n</div>\r\n<div class="layoutArea">\r\n<div class="column">\r\n<p>2016-09-30</p>\r\n</div>\r\n</div>\r\n</div>\r\n<div class="page" title="Page 4">\r\n<div class="layoutArea">\r\n<div class="column">\r\n<p>Städning:</p>\r\n<p>Greta behöver hjälp med att städa sin lägenhet. Vid städ får Greta hjälp med att dammsuga, städa badrummet och torka golven. Fråga Greta om hon vill vara med och hjälpa till vid städningen med att till exempel damma. Hjälp med att vattna blommor vid behov</p>\r\n<p>Vem utför insatsen:</p>\r\n<p>Förflyttningar och personlig vård &ndash; all personal<br /> Instruktioner från legitimerad personal, mediciner &ndash; all personal Att tvätta och torka kläder- all personal<br /> Att städa bostaden- kontaktman</p>\r\n<p>När ska stödet ges:</p>\r\n<p>Förflyttningar och personlig vård: - dygnet runt<br /> Dusch: en gång i veckan samt efter behov<br /> Instruktioner från legitimerad personal, mediciner - all personal Bereda måltider- dagligen<br /> Tvätta och torka kläder- vid behov<br /> Städa bostaden - var tredje vecka samt vid behov</p>\r\n<p>3. Mellanmänskliga interaktioner och relationer, utbildning, arbete, sysselsättning och ekonomiskt liv</p>\r\n<p>Vad ska stödet innehålla:</p>\r\n<p>&bull; Informella sociala relationer, stödjande/ tränande insats<br /> Delmål: Målet är att Greta ska stimuleras till relationer med andra utifrån sina egna</p>\r\n<p>förutsättningar</p>\r\n<p>Hur ska stödet ges:</p>\r\n<p>Informella sociala relationer - Prata så ofta som möjligt om Gretas närstående med henne och påminn henne om när det pågår gemensamma aktiviteter. Gretas syster kommer gärna och fikar på onsdagar. Fråga Greta om hon vill att systern ska komma och förbered henne på besöket genom att prata med henne om det.</p>\r\n<p>Vem utför insatsen:</p>\r\n<p>Informella sociala relationer - all personal</p>\r\n<p>När ska stödet ges:</p>\r\n<p>Informella sociala relationer - dagligen</p>\r\n</div>\r\n</div>\r\n<div class="layoutArea">\r\n<div class="column">\r\n<p>2016-09-30</p>\r\n</div>\r\n</div>\r\n</div>\r\n<div class="page" title="Page 5">\r\n<div class="layoutArea">\r\n<div class="column">\r\n<p>4. Samhällsgemenskap, socialt och medborgligt liv, känsla av trygghet och samhällstjänster och regelverk</p>\r\n<p>Vad ska stödet innehålla:</p>\r\n<ul>\r\n<li>\r\n<p>Från värdighetsgarantierna - egentid och utevistelse</p>\r\n</li>\r\n<li>\r\n<p>Från levnadsberättelse - samtal och aktiviteter</p>\r\n</li>\r\n<li>\r\n<p>Samhällstjänster och regelverk - fotvård, hårvård, tandvård:</p>\r\n</li>\r\n<li>\r\n<p>Känsla av trygghet &ndash; stödjande/tränande</p>\r\n<p>Delmål</p>\r\n<p>Målet är att skapa en trygg och meningsfull tillvaro för Greta.</p>\r\n<p>Hur ska stödet ges:<br /> Egentid, utevistelse, samtal, aktiviteter och känsla av trygghet - Erbjud Greta att gå ut på promenader eller sitta på altanen. Vid promenader sitter Greta i rullstol.<br /> Greta tycker mycket om att sitta och prata om sitt arbete och sin familj. Greta kan ibland bli stressad och få svårt att få fram orden när det är för många människor runt henne. Sitt därför gärna ensam med Greta och erbjud egentid vid samtal för att underlätta.<br /> Följ med Greta på de aktiviteter hon önskar vara med på, se boendets kulturblad för tips. Förklara tydligt för Greta vad som kommer att hända.</p>\r\n<p>Fotvård, hårvård, tandvård - På boendet finns frisör, fotvård och tandläkare. Kontaktman hjälper Greta att boka tid efter behov.<br /> Greta behöver hjälp med att följas till och från besöken.</p>\r\n<p>Vem utför insatsen:</p>\r\n<p>Samtal, aktiviteter och känsla av trygghet &ndash; all personal Egentid och utevistelse - kontaktman<br /> Fotvård, hårvård, tandvård: Privat utförare på boendet</p>\r\n<p>När ska stödet ges:</p>\r\n<p>Samtal och känsla av trygghet - dygnet runt<br /> Egentid - minst två timmar per månad<br /> Utevistelse- minst två tillfällen per vecka<br /> Aktiviteter - när det erbjuds på boendet, Se kulturblad för mer info Fotvård, hårvård, tandvård - vid kallelse eller behov</p>\r\n</li>\r\n</ul>\r\n</div>\r\n</div>\r\n</div>', '', '', 'test-link-pdf'),
(6, 'Implementation Plan', 2, 'n', '', 'implementation_plan', '0000-00-00 00:00:00', '2 Implementation Plan text Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat, Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat, Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat, Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat', '', '', 'test-link-pdf'),
(7, 'Nyhetsbrev', 0, 'y', '', 'newsletter', '0000-00-00 00:00:00', '', '', '', ''),
(8, 'Help', 0, 'n', 'Help ipsum dolor sit amet, consectetur adipiscing elit', 'help_page', '0000-00-00 00:00:00', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat, Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat, Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<br/> Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat, Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat ', '', '', ''),
(9, 'About', 0, 'n', 'About us ipsum dolor sit amet, consectetur adipiscing elit', 'about_page', '0000-00-00 00:00:00', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat, Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat, Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<br />\r\nUt enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat, Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat</p>\r\n', '', '', ''),
(10, 'Orders History', 0, 'n', 'History ipsum dolor sit amet, consectetur', 'orders_history', '0000-00-00 00:00:00', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo ', '', '', ''),
(12, 'Anslagstavla', 0, 'n', '', 'billboard', '0000-00-00 00:00:00', '', '', '', ''),
(13, 'Lorem Ipsum News 1', 0, 'n', '', 'newsletter', '2018-02-20 02:30:07', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laboru&nbsp;Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laboru</p>\r\n', '', '0O-DFVOm9J65bfL1O0zu-1GsCnr0UrPq.jpg', ''),
(14, 'Lorem Ipsum News 2', 0, 'n', '', 'newsletter', '2018-02-20 02:30:07', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laboru&nbsp;Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laboru</p>\r\n', '', '0O-DFVOm9J65bfL1O0zu-1GsCnr0UrPq.jpg', ''),
(15, 'Lorem Ipsum News 3', 0, 'n', '', 'newsletter', '2018-02-20 02:30:07', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laboru&nbsp;Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laboru</p>\r\n', '', '0O-DFVOm9J65bfL1O0zu-1GsCnr0UrPq.jpg', ''),
(16, 'Lorem Ipsum News 4', 0, 'n', '', 'newsletter', '2018-02-20 02:30:07', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laboru&nbsp;Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laboru</p>\r\n', '', '0O-DFVOm9J65bfL1O0zu-1GsCnr0UrPq.jpg', ''),
(17, 'Lorem Ipsum News 5', 0, 'n', '', 'newsletter', '2018-02-20 02:30:07', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laboru&nbsp;Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laboru</p>\r\n', '', '0O-DFVOm9J65bfL1O0zu-1GsCnr0UrPq.jpg', ''),
(18, 'Lorem Ipsum News 6', 0, 'n', '', 'newsletter', '2018-02-20 02:30:07', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laboru&nbsp;Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laboru</p>\r\n', '', '0O-DFVOm9J65bfL1O0zu-1GsCnr0UrPq.jpg', ''),
(19, 'About Provider', 0, 'n', 'Lorem Ipsum', 'about_page', NULL, '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborumLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborumLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborumLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>\r\n', '', '5ye1el8kGyk84p0cGmAhl_BLgt-DpzDc.jpg', ''),
(20, 'Diary Inner Document 1', 0, 'n', '', 'diary', '2018-02-11 09:45:53', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>\r\n', '', '', ''),
(21, 'Diary Inner Document 2', 0, 'n', '', 'diary', '2018-02-11 09:45:53', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>\r\n', '', '', ''),
(22, 'Diary Inner Document 3', 0, 'n', '', 'diary', '2018-02-11 09:45:53', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>\r\n', '', '', ''),
(23, 'Diary Inner Document 3', 0, 'n', '', 'diary', '2018-02-11 09:45:53', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>\r\n', '', '', ''),
(24, 'Diary Inner Document 4', 0, 'n', '', 'diary', '2018-02-11 09:45:53', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>\r\n', '', '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `cl_1_modules`
--

DROP TABLE IF EXISTS `cl_1_modules`;
CREATE TABLE IF NOT EXISTS `cl_1_modules` (
  `module_id` int(15) NOT NULL AUTO_INCREMENT,
  `module_name` varchar(255) NOT NULL,
  `sub_module` varchar(1) NOT NULL DEFAULT 'n',
  `sort_order` int(10) NOT NULL,
  `comment` varchar(500) NOT NULL,
  `parent_page` varchar(155) NOT NULL,
  `module_icon` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT 'y',
  `module_role_id` varchar(255) NOT NULL DEFAULT '4',
  `module_type` varchar(100) NOT NULL,
  PRIMARY KEY (`module_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Дамп данных таблицы `cl_1_modules`
--

INSERT INTO `cl_1_modules` (`module_id`, `module_name`, `sub_module`, `sort_order`, `comment`, `parent_page`, `module_icon`, `link`, `status`, `module_role_id`, `module_type`) VALUES
(1, 'Dagbok', 'n', 2, '', '', 'carelink-diary', 'diary', 'y', '|2|3', 'doc-list'),
(2, 'Om brukaren ', 'n', 10, '', '', 'ios-contact-outline', 'about_patient', 'y', '|2|3', 'document'),
(3, 'Genomförandeplan', 'n', 9, '', '', 'ios-bookmarks-outline', 'implementation_plan', 'y', '|2|3', 'document'),
(4, 'Anslagstavla', 'n', 6, '', '', 'carelink-care', 'billboard', 'y', '|2|3', 'document'),
(5, 'Kalendarium', 'n', 7, '', '', 'ios-calendar-outline', 'calendar', 'y', '|2|3|4', 'document'),
(6, 'Nyhetsbrev', 'n', 8, '', '', 'ios-paper-outline', 'newsletter', 'y', '|2|3|4', 'doc-list'),
(7, 'Meddelanden', 'n', 1, '', '', 'carelink-messages', 'messaging', 'y', '|2|3|4', ''),
(8, 'Matsedel', 'n', 5, 'Only show food menu. To allow ordering also food_menu_sub_order must be enabled', '', 'carelink-food', 'food_menu', 'y', '|3|4', 'product'),
(9, 'Food Menu sub order', 'y', 0, 'Allow to order from food menu', 'food_menu', 'carelink-food', 'food_menu_sub_order', 'y', '4', 'orders-list'),
(10, 'Tjänster', 'n', 3, '', '', 'carelink-accomp_order', 'core_services', 'y', '|3|4', 'orders-list'),
(11, 'Order Accompanier', 'y', 0, '', 'core_services', 'carelink-accomp_order', 'core_services_sub_accompanier', 'y', '|3|4', 'product'),
(12, 'Apotekshämtning', 'y', 0, '', 'core_services', 'carelink-medical', 'core_services_sub_pharmacy', 'y', '|3|4', 'product'),
(13, 'Avboka Ledsagning', 'y', 0, '', 'core_services', 'carelink-accomp_cancel', 'core_services_sub_cancel', 'y', '|3|4', 'product'),
(14, 'Tilläggstjänster', 'n', 4, 'Här kan du beställa tilläggstjänster som  är utöver det som ingår i biståndsbeslutet. Du betalar själv för dessa tjänster.', '', 'ios-paper-outline', 'additional_services', 'y', '|3|4', 'orders-list');

-- --------------------------------------------------------

--
-- Структура таблицы `cl_1_orders`
--

DROP TABLE IF EXISTS `cl_1_orders`;
CREATE TABLE IF NOT EXISTS `cl_1_orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_title` varchar(150) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_type` varchar(100) NOT NULL,
  `create_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `price` float NOT NULL,
  `order_status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=37 ;

-- --------------------------------------------------------

--
-- Структура таблицы `cl_1_order_items`
--

DROP TABLE IF EXISTS `cl_1_order_items`;
CREATE TABLE IF NOT EXISTS `cl_1_order_items` (
  `order_item_id` int(15) NOT NULL AUTO_INCREMENT,
  `order_id` int(15) NOT NULL,
  `prod_item_id` int(15) NOT NULL,
  `order_data` varchar(500) NOT NULL,
  `sort_id` int(15) NOT NULL,
  PRIMARY KEY (`order_item_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

-- --------------------------------------------------------

--
-- Структура таблицы `cl_1_products`
--

DROP TABLE IF EXISTS `cl_1_products`;
CREATE TABLE IF NOT EXISTS `cl_1_products` (
  `prod_id` int(15) NOT NULL AUTO_INCREMENT COMMENT 'product id',
  `product_title` varchar(500) NOT NULL,
  `product_type` varchar(150) NOT NULL COMMENT 'parent menu',
  `page_link` varchar(100) NOT NULL,
  `product_desc` text NOT NULL COMMENT 'product custom description',
  `icon` varchar(100) NOT NULL,
  `sort_id` int(15) DEFAULT '0',
  PRIMARY KEY (`prod_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Дамп данных таблицы `cl_1_products`
--

INSERT INTO `cl_1_products` (`prod_id`, `product_title`, `product_type`, `page_link`, `product_desc`, `icon`, `sort_id`) VALUES
(2, 'Boka Ledsagning', 'core_services', 'core_services_sub_accompanier', 'Du som har rätt till ledsagning kan boka det här.', 'carelink-accomp_order', 1),
(3, 'Avboka Ledsagning', 'core_services', 'core_services_sub_cancel', 'Ange tidpunkt för den ledsagning du vill avboka.', 'carelink-accomp_cancel', 2),
(4, 'Apotekshämtning', 'core_services', 'core_services_sub_pharmacy', 'Om du har recept eller läkemedel som behöver hämtas utöver vanliga hämtningstider. Ange vad som ska hämtas och eventuella andra uppgifter som behövs.', 'carelink-medical', 3),
(5, 'Avboka Hemtjänstbesök', 'core_services', 'cancel_visit', 'Avboka besök från hemtjänsten. Detta kommer även att avboka matbeställningar och andra tjänster under tidsperioden. Om du bara vill avboka besöken men t.ex. fortfarande ha mat, ange detta i kommentarsfältet.', 'carelink-cancel_visit', 4),
(6, 'Fotvård', 'additional_services', 'foot_care', 'Fotvård från Fotlisa som också kan komma hem till dig.\r\nJag är utbildad medicinsk fotvårsterapeut på Axelsons Gymnastiska Institut i Stockholm, är medlem i Sveriges Fotterapeuter, innehar behandlingsskadeförsäkring och följer miljö- och hälsas hygienkrav.', 'carelink-footprint', 1),
(7, 'Massage', 'additional_services', 'massage', '', 'carelink-massage', 1),
(8, 'Extra ledsagning', 'additional_services', 'watching', '', 'carelink-care', 1),
(9, 'Husdjur', 'additional_services', 'pets', '', 'carelink-dogs', 1),
(10, 'Extra städning', 'additional_services', 'extra_cleaning', '', 'carelink-cleaning', 1),
(11, 'Bowling', 'additional_services', 'promenade', '', 'carelink-promenad', 1),
(12, 'Snöskottning', 'additional_services', 'snow_cleaning', '', 'carelink-snowman', 1),
(13, 'Gymnastik', 'additional_services', 'gymnastics', '', 'carelink-sport', 1),
(14, 'Food Menu', '', 'food_menu', 'Här är veckans meny. Hoppas att du ska hitta något som smakar!\r\n\r\nVi anlitar kommunens egen kost- och restaurangenhet som svarar för näringsriktiga menyer och måltider. De är utformade av egna dietister och med ekologiska, närproducerade råvaror så långt det är möjligt.\r\nHembakat mat- och fikabröd, hemlagad sylt och marmelader är populära.', 'carelink-food', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `cl_1_product_items`
--

DROP TABLE IF EXISTS `cl_1_product_items`;
CREATE TABLE IF NOT EXISTS `cl_1_product_items` (
  `prod_item_id` int(15) NOT NULL AUTO_INCREMENT,
  `product_id` int(15) NOT NULL,
  `sort_id` int(11) NOT NULL,
  `product_item_type` varchar(255) NOT NULL,
  `mandatory` varchar(1) NOT NULL DEFAULT 'n',
  `title` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `price` float DEFAULT '0',
  PRIMARY KEY (`prod_item_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=58 ;

--
-- Дамп данных таблицы `cl_1_product_items`
--

INSERT INTO `cl_1_product_items` (`prod_item_id`, `product_id`, `sort_id`, `product_item_type`, `mandatory`, `title`, `description`, `price`) VALUES
(24, 14, 0, 'single_choice', 'n', 'Måndag', '', NULL),
(25, 14, 0, 'single_choice', 'n', 'Tisdag', '', NULL),
(26, 14, 0, 'single_choice', 'n', 'Onsdag', '', NULL),
(27, 14, 0, 'single_choice', 'n', 'Torsdag', '', NULL),
(29, 14, 0, 'single_choice', 'n', 'Fredag', '', NULL),
(30, 14, 0, 'single_choice', 'n', 'Lördag', '', NULL),
(31, 14, 6, 'single_choice', 'n', 'Söndag', '', NULL),
(32, 6, 0, 'single_choice', 'n', 'Fotvård hos Fotlisa', '', 325),
(33, 6, 0, 'datetime', 'n', 'Önskat datum', 'Ange önskad tidpunkt för behandling', NULL),
(34, 6, 0, 'text', 'n', 'Kommentar', 'Ange här om du har några särskilda önskemål', NULL),
(35, 2, 1, 'datetime', 'y', 'Tidpunkt', '', 0),
(36, 2, 2, 'text', 'y', 'Orsak och Adress', 'Ange orsaken till ledsagning, t.ex. läkarbesök, samt adress', 0),
(38, 3, 1, 'datetime', 'n', 'Tidpunkt', '', 0),
(39, 4, 1, 'text', 'y', 'Upphämtningsinformation', '', 0),
(40, 5, 1, 'datetime', 'y', 'Från', '', 0),
(41, 5, 2, 'datetime', 'y', 'Till', '', 0),
(42, 5, 3, 'text', 'n', 'Kommentar', '', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `cl_1_prod_item_choices`
--

DROP TABLE IF EXISTS `cl_1_prod_item_choices`;
CREATE TABLE IF NOT EXISTS `cl_1_prod_item_choices` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `prod_item_id` int(15) NOT NULL,
  `sort_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=89 ;

--
-- Дамп данных таблицы `cl_1_prod_item_choices`
--

INSERT INTO `cl_1_prod_item_choices` (`id`, `prod_item_id`, `sort_id`, `title`, `description`, `price`) VALUES
(3, 24, 2, 'Kyckling á la king med kokt ris och haricot verts. Hallonkräm med mjölk.', '', 0),
(4, 24, 1, 'Sej med kokt färskpotatis och vitvinsås', '', 0),
(7, 25, 1, 'Makaronipudding med skirat smör och kokta morötter.', '', 0),
(8, 25, 1, 'Kokt torsk i ägg- och persiljesås, kokt potatis & ärtor. Bär med grädde.', '', 0),
(11, 26, 1, 'Fylld falukorv med potatismos och grönsaksmix.', '', 0),
(12, 26, 1, 'Raggmunk med bacon, rårivna morötter och lingonsylt. Äppelkompott med grädde', '', 0),
(15, 27, 1, 'Sjömanslåda med potatis, stjärnsallad och lingonsylt.', '', 0),
(16, 27, 1, 'Kålrotssoppa med mjuk bröd och skinka. Blåbärsfras med vispad grädde', '', 0),
(19, 29, 1, 'Grekisk köttfärsgratäng, sallad med tomat och salladsost', '', 0),
(20, 29, 1, 'Pasta med bacon- och svampsås, veckosallad. Päronsoppa med grädde.', '', 0),
(23, 30, 1, 'Stekt kyckling med rosépepparsås, kokt potatis och grillgrönsaker.', '', 0),
(24, 30, 1, 'Spenatsoppa med ägghalva. Tunnpannkaka med sylt och grädde.', '', 0),
(27, 31, 1, 'Kallskuret kött, pepparsås, potatisgratäng, grönsaksblandning & gelé. Pannacotta', '', 0),
(28, 31, 1, 'Viltskavsgryta med kokt ris, grönsallad och lingonsylt. Glass med kolasås.', '', 0),
(31, 32, 1, 'Fotvård 60 min', '', 0),
(32, 32, 1, 'Fotvård 60 min hembesök', '', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `cl_groups`
--

DROP TABLE IF EXISTS `cl_groups`;
CREATE TABLE IF NOT EXISTS `cl_groups` (
  `group_id` int(15) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `provider_id` int(15) NOT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Структура таблицы `cl_group_members`
--

DROP TABLE IF EXISTS `cl_group_members`;
CREATE TABLE IF NOT EXISTS `cl_group_members` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `group_id` int(15) DEFAULT '0',
  `user_id` int(15) NOT NULL,
  `parent_id` int(15) NOT NULL,
  `group_type` varchar(15) NOT NULL DEFAULT 'patient' COMMENT 'group | patient',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=135 ;

-- --------------------------------------------------------

--
-- Структура таблицы `cl_logs`
--

DROP TABLE IF EXISTS `cl_logs`;
CREATE TABLE IF NOT EXISTS `cl_logs` (
  `lid` int(15) NOT NULL AUTO_INCREMENT,
  `action_type` int(15) NOT NULL,
  `created_by` int(15) NOT NULL,
  `created_time` datetime NOT NULL,
  `updated_by` int(15) NOT NULL,
  `updated_time` datetime NOT NULL,
  PRIMARY KEY (`lid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `cl_messages`
--

DROP TABLE IF EXISTS `cl_messages`;
CREATE TABLE IF NOT EXISTS `cl_messages` (
  `mid` int(15) NOT NULL AUTO_INCREMENT,
  `user_id` int(15) NOT NULL,
  `created` datetime NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '1=new; 2=read',
  `attachment` varchar(255) NOT NULL,
  `message` varchar(555) NOT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY (`mid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `cl_providers`
--

DROP TABLE IF EXISTS `cl_providers`;
CREATE TABLE IF NOT EXISTS `cl_providers` (
  `provider_id` int(15) NOT NULL AUTO_INCREMENT,
  `provider_title` varchar(255) NOT NULL,
  `provider_logo` varchar(150) NOT NULL,
  `provider_menu_logo` varchar(255) NOT NULL,
  `color_model` varchar(500) NOT NULL,
  `provider_info` varchar(500) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '0=active; 1=block',
  `currency` varchar(15) NOT NULL DEFAULT 'kr' COMMENT '€ | $ | kr',
  `currency_place` varchar(15) NOT NULL DEFAULT 'after' COMMENT 'before | after',
  PRIMARY KEY (`provider_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Дамп данных таблицы `cl_providers`
--

INSERT INTO `cl_providers` (`provider_id`, `provider_title`, `provider_logo`, `provider_menu_logo`, `color_model`, `provider_info`, `status`, `currency`, `currency_place`) VALUES
(1, 'TestProvider', 'MdyF584Ic9m4fWsQs4EK7EBtEDMfk3BM.png', 'habVd4V_Q3oz7hH0ySiFBt68Ts3fvDgj.png', '', 'Lorem Ipsum Dolor Sit Amet!1', 0, 'SEK', 'before');

-- --------------------------------------------------------


--
-- Структура таблицы `cl_push`
--

DROP TABLE IF EXISTS `cl_push`;
CREATE TABLE IF NOT EXISTS `cl_push` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(15) NOT NULL,
  `push_title` varchar(150) NOT NULL,
  `push_type` varchar(50) NOT NULL,
  `created_time` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `status` int(1) NOT NULL COMMENT '0 - new; 1 - read',
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Дамп данных таблицы `cl_push`
--

INSERT INTO `cl_push` (`pid`, `user_id`, `push_title`, `push_type`, `created_time`, `updated`, `status`) VALUES
(1, 2, 'Ändrade öppettider', 'alert', '2018-01-11 00:00:00', '0000-00-00 00:00:00', 0),
(2, 4, 'Ändrade öppettider', 'alert', '2018-01-10 00:00:00', '0000-00-00 00:00:00', 0),
(3, 2, 'Nytt meddelande från Oscar Johnsson', 'message', '2018-01-09 00:00:00', '2018-01-11 00:00:00', 0),
(4, 4, 'Nytt meddelande från Karl Persson', 'message', '2018-01-10 00:00:00', '2018-01-11 00:00:00', 0),
(5, 2, 'Det finns ett ny nyhetsbrev', 'news', '2018-01-10 00:00:00', '2018-01-11 00:00:00', 0),
(6, 4, 'Det finns ett ny nyhetsbrev', 'news', '2018-01-11 00:00:00', '2018-01-11 00:00:00', 0),
(7, 2, '2222 Example last news title...', 'news', '2018-01-07 00:00:00', '2018-01-07 00:00:00', 0),
(8, 4, '33333 Example last news title...', 'news', '2018-01-07 00:00:00', '2018-01-07 00:00:00', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `cl_settings`
--

DROP TABLE IF EXISTS `cl_settings`;
CREATE TABLE IF NOT EXISTS `cl_settings` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `setting` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `cl_settings`
--

INSERT INTO `cl_settings` (`id`, `setting`, `value`) VALUES
(1, 'app_version_required', '0.2');

-- --------------------------------------------------------

--
-- Структура таблицы `cl_users`
--

DROP TABLE IF EXISTS `cl_users`;
CREATE TABLE IF NOT EXISTS `cl_users` (
  `user_id` int(15) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `password` varchar(500) NOT NULL,
  `authToken` varchar(500) NOT NULL COMMENT 'Security AuthToken',
  `bankid` varchar(100) NOT NULL,
  `user_role` int(11) NOT NULL DEFAULT '3',
  `provider_id` int(15) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `photo` varchar(100) NOT NULL,
  `status` int(1) NOT NULL,
  `lang` varchar(5) NOT NULL,
  `auth_key` varchar(500) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Дамп данных таблицы `cl_users`
--

INSERT INTO `cl_users` (`user_id`, `login`, `password`, `authToken`, `bankid`, `user_role`, `provider_id`, `first_name`, `last_name`, `phone`, `email`, `address`, `city`, `photo`, `status`, `lang`, `auth_key`, `updated_at`, `created_at`) VALUES
(1, 'admin', '$2y$13$Q/srdvQ2LwTQHo/8vsCz7ujWBWSle1UlaGtfHsyGGyTemfLyXBFFe', '', '0', 0, 0, 'John', 'Snow', '10123456789', 'testadmin@email.com', '', '', '', 1, 'en', '', '2018-01-25 20:51:30', '0000-00-00 00:00:00'),
(11, 'provider1', '$2y$13$OToHWR23Bxr8z.BAbcdQTe4USsCgzuv4ow9J8J1mKPicO2NzB8j5m', 'fd515647bc33a1628f25299fac2de4c6', '', 1, 1, 'Ipsum', 'Lorem', '111111', 'asdasd@dsfsd.c1', '', '', 'so943GDjANXLCSndMZB1834wtgmtoeOW.jpg', 1, '', 'GfdxbWzp3UjtsBPA1qWL4-xjCSh9Jw9U', '2018-02-01 22:41:31', '0000-00-00 00:00:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
