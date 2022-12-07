<?php
function gutenify_font_families() {
	$font_families = array(
		array(
			'fontFamily' => '-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif',
			'name'       => 'System Font',
			'slug'       => 'system',
		),
		array(
			'fontFamily' => '\'Lato\', sans-serif',
			'name'       => 'Lato Sans Serif',
			'slug'       => 'lato-sans-serif',
		),
		array(
			'fontFamily' => '\'Roboto\', sans-serif',
			'name'       => 'Roboto',
			'slug'       => 'roboto-sans-serif',
		),
		array(
			'fontFamily' => '\'Roboto Condensed\', sans-serif',
			'name'       => 'Roboto Condensed Sans Serif',
			'slug'       => 'roboto-condensed-sans-serif',
		),
		array(
			'fontFamily' => '\'Roboto Slab\', sans-serif',
			'name'       => 'Roboto Slab Sans Serif',
			'slug'       => 'roboto-slab-sans-serif',
		),
		array(
			'fontFamily' => '\'Poppins\', sans-serif',
			'name'       => 'Poppins',
			'slug'       => 'poppins-sans-serif',
		),
		array(
			'fontFamily' => '\'Inter\', sans-serif',
			'name'       => 'Inter Sans Serif',
			'slug'       => 'inter-sans-serif',
		),
		array(
			'fontFamily' => "'Hurricane', cursive",
			'name'       => 'Hurricane',
			'slug'       => 'hurricane-cursive',
		),
		array(
			'fontFamily' => "'Palette Mosaic', cursive",
			'name'       => 'Palette Mosaic',
			'slug'       => 'palette-mosaic-cursive',
		),
		array(
			'fontFamily' => "'Source Sans Pro', sans-serif",
			'name'       => 'Source Sans Pro',
			'slug'       => 'source-sans-pro',
		),
		array(
			'fontFamily' => "'Roboto Flex', sans-serif",
			'name'       => 'Roboto Flex',
			'slug'       => 'roboto-flex',
		),
		// New fonts ele.
array(
	"fontFamily" => "ABeeZee",
	"name" => "ABeeZee",
	"slug" => "abeezee"
    ) , array(
	"fontFamily" => "Abel",
	"name" => "Abel",
	"slug" => "abel"
    ) , array(
	"fontFamily" => "Abhaya Libre",
	"name" => "Abhaya Libre",
	"slug" => "abhaya-libre"
    ) , array(
	"fontFamily" => "Abril Fatface",
	"name" => "Abril Fatface",
	"slug" => "abril-fatface"
    ) , array(
	"fontFamily" => "Aclonica",
	"name" => "Aclonica",
	"slug" => "aclonica"
    ) , array(
	"fontFamily" => "Acme",
	"name" => "Acme",
	"slug" => "acme"
    ) , array(
	"fontFamily" => "Actor",
	"name" => "Actor",
	"slug" => "actor"
    ) , array(
	"fontFamily" => "Adamina",
	"name" => "Adamina",
	"slug" => "adamina"
    ) , array(
	"fontFamily" => "Advent Pro",
	"name" => "Advent Pro",
	"slug" => "advent-pro"
    ) , array(
	"fontFamily" => "Aguafina Script",
	"name" => "Aguafina Script",
	"slug" => "aguafina-script"
    ) , array(
	"fontFamily" => "Akaya Kanadaka",
	"name" => "Akaya Kanadaka",
	"slug" => "akaya-kanadaka"
    ) , array(
	"fontFamily" => "Akaya Telivigala",
	"name" => "Akaya Telivigala",
	"slug" => "akaya-telivigala"
    ) , array(
	"fontFamily" => "Akronim",
	"name" => "Akronim",
	"slug" => "akronim"
    ) , array(
	"fontFamily" => "Aladin",
	"name" => "Aladin",
	"slug" => "aladin"
    ) , array(
	"fontFamily" => "Alata",
	"name" => "Alata",
	"slug" => "alata"
    ) , array(
	"fontFamily" => "Alatsi",
	"name" => "Alatsi",
	"slug" => "alatsi"
    ) , array(
	"fontFamily" => "Aldrich",
	"name" => "Aldrich",
	"slug" => "aldrich"
    ) , array(
	"fontFamily" => "Alef",
	"name" => "Alef",
	"slug" => "alef"
    ) , array(
	"fontFamily" => "Alegreya",
	"name" => "Alegreya",
	"slug" => "alegreya"
    ) , array(
	"fontFamily" => "Alegreya SC",
	"name" => "Alegreya SC",
	"slug" => "alegreya-sc"
    ) , array(
	"fontFamily" => "Alegreya Sans",
	"name" => "Alegreya Sans",
	"slug" => "alegreya-sans"
    ) , array(
	"fontFamily" => "Alegreya Sans SC",
	"name" => "Alegreya Sans SC",
	"slug" => "alegreya-sans-sc"
    ) , array(
	"fontFamily" => "Aleo",
	"name" => "Aleo",
	"slug" => "aleo"
    ) , array(
	"fontFamily" => "Alex Brush",
	"name" => "Alex Brush",
	"slug" => "alex-brush"
    ) , array(
	"fontFamily" => "Alfa Slab One",
	"name" => "Alfa Slab One",
	"slug" => "alfa-slab-one"
    ) , array(
	"fontFamily" => "Alice",
	"name" => "Alice",
	"slug" => "alice"
    ) , array(
	"fontFamily" => "Alike",
	"name" => "Alike",
	"slug" => "alike"
    ) , array(
	"fontFamily" => "Alike Angular",
	"name" => "Alike Angular",
	"slug" => "alike-angular"
    ) , array(
	"fontFamily" => "Allan",
	"name" => "Allan",
	"slug" => "allan"
    ) , array(
	"fontFamily" => "Allerta",
	"name" => "Allerta",
	"slug" => "allerta"
    ) , array(
	"fontFamily" => "Allerta Stencil",
	"name" => "Allerta Stencil",
	"slug" => "allerta-stencil"
    ) , array(
	"fontFamily" => "Allison",
	"name" => "Allison",
	"slug" => "allison"
    ) , array(
	"fontFamily" => "Allura",
	"name" => "Allura",
	"slug" => "allura"
    ) , array(
	"fontFamily" => "Almarai",
	"name" => "Almarai",
	"slug" => "almarai"
    ) , array(
	"fontFamily" => "Almendra",
	"name" => "Almendra",
	"slug" => "almendra"
    ) , array(
	"fontFamily" => "Almendra Display",
	"name" => "Almendra Display",
	"slug" => "almendra-display"
    ) , array(
	"fontFamily" => "Almendra SC",
	"name" => "Almendra SC",
	"slug" => "almendra-sc"
    ) , array(
	"fontFamily" => "Alumni Sans",
	"name" => "Alumni Sans",
	"slug" => "alumni-sans"
    ) , array(
	"fontFamily" => "Amarante",
	"name" => "Amarante",
	"slug" => "amarante"
    ) , array(
	"fontFamily" => "Amaranth",
	"name" => "Amaranth",
	"slug" => "amaranth"
    ) , array(
	"fontFamily" => "Amatic SC",
	"name" => "Amatic SC",
	"slug" => "amatic-sc"
    ) , array(
	"fontFamily" => "Amethysta",
	"name" => "Amethysta",
	"slug" => "amethysta"
    ) , array(
	"fontFamily" => "Amiko",
	"name" => "Amiko",
	"slug" => "amiko"
    ) , array(
	"fontFamily" => "Amiri",
	"name" => "Amiri",
	"slug" => "amiri"
    ) , array(
	"fontFamily" => "Amita",
	"name" => "Amita",
	"slug" => "amita"
    ) , array(
	"fontFamily" => "Anaheim",
	"name" => "Anaheim",
	"slug" => "anaheim"
    ) , array(
	"fontFamily" => "Andada Pro",
	"name" => "Andada Pro",
	"slug" => "andada-pro"
    ) , array(
	"fontFamily" => "Andika",
	"name" => "Andika",
	"slug" => "andika"
    ) , array(
	"fontFamily" => "Andika New Basic",
	"name" => "Andika New Basic",
	"slug" => "andika-new-basic"
    ) , array(
	"fontFamily" => "Angkor",
	"name" => "Angkor",
	"slug" => "angkor"
    ) , array(
	"fontFamily" => "Annie Use Your Telescope",
	"name" => "Annie Use Your Telescope",
	"slug" => "annie-use-your-telescope"
    ) , array(
	"fontFamily" => "Anonymous Pro",
	"name" => "Anonymous Pro",
	"slug" => "anonymous-pro"
    ) , array(
	"fontFamily" => "Antic",
	"name" => "Antic",
	"slug" => "antic"
    ) , array(
	"fontFamily" => "Antic Didone",
	"name" => "Antic Didone",
	"slug" => "antic-didone"
    ) , array(
	"fontFamily" => "Antic Slab",
	"name" => "Antic Slab",
	"slug" => "antic-slab"
    ) , array(
	"fontFamily" => "Anton",
	"name" => "Anton",
	"slug" => "anton"
    ) , array(
	"fontFamily" => "Antonio",
	"name" => "Antonio",
	"slug" => "antonio"
    ) , array(
	"fontFamily" => "Arapey",
	"name" => "Arapey",
	"slug" => "arapey"
    ) , array(
	"fontFamily" => "Arbutus",
	"name" => "Arbutus",
	"slug" => "arbutus"
    ) , array(
	"fontFamily" => "Arbutus Slab",
	"name" => "Arbutus Slab",
	"slug" => "arbutus-slab"
    ) , array(
	"fontFamily" => "Architects Daughter",
	"name" => "Architects Daughter",
	"slug" => "architects-daughter"
    ) , array(
	"fontFamily" => "Archivo",
	"name" => "Archivo",
	"slug" => "archivo"
    ) , array(
	"fontFamily" => "Archivo Black",
	"name" => "Archivo Black",
	"slug" => "archivo-black"
    ) , array(
	"fontFamily" => "Archivo Narrow",
	"name" => "Archivo Narrow",
	"slug" => "archivo-narrow"
    ) , array(
	"fontFamily" => "Are You Serious",
	"name" => "Are You Serious",
	"slug" => "are-you-serious"
    ) , array(
	"fontFamily" => "Aref Ruqaa",
	"name" => "Aref Ruqaa",
	"slug" => "aref-ruqaa"
    ) , array(
	"fontFamily" => "Arima Madurai",
	"name" => "Arima Madurai",
	"slug" => "arima-madurai"
    ) , array(
	"fontFamily" => "Arimo",
	"name" => "Arimo",
	"slug" => "arimo"
    ) , array(
	"fontFamily" => "Arizonia",
	"name" => "Arizonia",
	"slug" => "arizonia"
    ) , array(
	"fontFamily" => "Armata",
	"name" => "Armata",
	"slug" => "armata"
    ) , array(
	"fontFamily" => "Arsenal",
	"name" => "Arsenal",
	"slug" => "arsenal"
    ) , array(
	"fontFamily" => "Artifika",
	"name" => "Artifika",
	"slug" => "artifika"
    ) , array(
	"fontFamily" => "Arvo",
	"name" => "Arvo",
	"slug" => "arvo"
    ) , array(
	"fontFamily" => "Arya",
	"name" => "Arya",
	"slug" => "arya"
    ) , array(
	"fontFamily" => "Asap",
	"name" => "Asap",
	"slug" => "asap"
    ) , array(
	"fontFamily" => "Asap Condensed",
	"name" => "Asap Condensed",
	"slug" => "asap-condensed"
    ) , array(
	"fontFamily" => "Asar",
	"name" => "Asar",
	"slug" => "asar"
    ) , array(
	"fontFamily" => "Asset",
	"name" => "Asset",
	"slug" => "asset"
    ) , array(
	"fontFamily" => "Assistant",
	"name" => "Assistant",
	"slug" => "assistant"
    ) , array(
	"fontFamily" => "Astloch",
	"name" => "Astloch",
	"slug" => "astloch"
    ) , array(
	"fontFamily" => "Asul",
	"name" => "Asul",
	"slug" => "asul"
    ) , array(
	"fontFamily" => "Athiti",
	"name" => "Athiti",
	"slug" => "athiti"
    ) , array(
	"fontFamily" => "Atkinson Hyperlegible",
	"name" => "Atkinson Hyperlegible",
	"slug" => "atkinson-hyperlegible"
    ) , array(
	"fontFamily" => "Atma",
	"name" => "Atma",
	"slug" => "atma"
    ) , array(
	"fontFamily" => "Atomic Age",
	"name" => "Atomic Age",
	"slug" => "atomic-age"
    ) , array(
	"fontFamily" => "Aubrey",
	"name" => "Aubrey",
	"slug" => "aubrey"
    ) , array(
	"fontFamily" => "Audiowide",
	"name" => "Audiowide",
	"slug" => "audiowide"
    ) , array(
	"fontFamily" => "Autour One",
	"name" => "Autour One",
	"slug" => "autour-one"
    ) , array(
	"fontFamily" => "Average",
	"name" => "Average",
	"slug" => "average"
    ) , array(
	"fontFamily" => "Average Sans",
	"name" => "Average Sans",
	"slug" => "average-sans"
    ) , array(
	"fontFamily" => "Averia Gruesa Libre",
	"name" => "Averia Gruesa Libre",
	"slug" => "averia-gruesa-libre"
    ) , array(
	"fontFamily" => "Averia Libre",
	"name" => "Averia Libre",
	"slug" => "averia-libre"
    ) , array(
	"fontFamily" => "Averia Sans Libre",
	"name" => "Averia Sans Libre",
	"slug" => "averia-sans-libre"
    ) , array(
	"fontFamily" => "Averia Serif Libre",
	"name" => "Averia Serif Libre",
	"slug" => "averia-serif-libre"
    ) , array(
	"fontFamily" => "Azeret Mono",
	"name" => "Azeret Mono",
	"slug" => "azeret-mono"
    ) , array(
	"fontFamily" => "B612",
	"name" => "B612",
	"slug" => "b612"
    ) , array(
	"fontFamily" => "B612 Mono",
	"name" => "B612 Mono",
	"slug" => "b612-mono"
    ) , array(
	"fontFamily" => "Bad Script",
	"name" => "Bad Script",
	"slug" => "bad-script"
    ) , array(
	"fontFamily" => "Bahiana",
	"name" => "Bahiana",
	"slug" => "bahiana"
    ) , array(
	"fontFamily" => "Bahianita",
	"name" => "Bahianita",
	"slug" => "bahianita"
    ) , array(
	"fontFamily" => "Bai Jamjuree",
	"name" => "Bai Jamjuree",
	"slug" => "bai-jamjuree"
    ) , array(
	"fontFamily" => "Bakbak One",
	"name" => "Bakbak One",
	"slug" => "bakbak-one"
    ) , array(
	"fontFamily" => "Ballet",
	"name" => "Ballet",
	"slug" => "ballet"
    ) , array(
	"fontFamily" => "Baloo 2",
	"name" => "Baloo 2",
	"slug" => "baloo-2"
    ) , array(
	"fontFamily" => "Baloo Bhai 2",
	"name" => "Baloo Bhai 2",
	"slug" => "baloo-bhai-2"
    ) , array(
	"fontFamily" => "Baloo Bhaijaan 2",
	"name" => "Baloo Bhaijaan 2",
	"slug" => "baloo-bhaijaan-2"
    ) , array(
	"fontFamily" => "Baloo Bhaina 2",
	"name" => "Baloo Bhaina 2",
	"slug" => "baloo-bhaina-2"
    ) , array(
	"fontFamily" => "Baloo Chettan 2",
	"name" => "Baloo Chettan 2",
	"slug" => "baloo-chettan-2"
    ) , array(
	"fontFamily" => "Baloo Da 2",
	"name" => "Baloo Da 2",
	"slug" => "baloo-da-2"
    ) , array(
	"fontFamily" => "Baloo Paaji 2",
	"name" => "Baloo Paaji 2",
	"slug" => "baloo-paaji-2"
    ) , array(
	"fontFamily" => "Baloo Tamma 2",
	"name" => "Baloo Tamma 2",
	"slug" => "baloo-tamma-2"
    ) , array(
	"fontFamily" => "Baloo Tammudu 2",
	"name" => "Baloo Tammudu 2",
	"slug" => "baloo-tammudu-2"
    ) , array(
	"fontFamily" => "Baloo Thambi 2",
	"name" => "Baloo Thambi 2",
	"slug" => "baloo-thambi-2"
    ) , array(
	"fontFamily" => "Balsamiq Sans",
	"name" => "Balsamiq Sans",
	"slug" => "balsamiq-sans"
    ) , array(
	"fontFamily" => "Balthazar",
	"name" => "Balthazar",
	"slug" => "balthazar"
    ) , array(
	"fontFamily" => "Bangers",
	"name" => "Bangers",
	"slug" => "bangers"
    ) , array(
	"fontFamily" => "Barlow",
	"name" => "Barlow",
	"slug" => "barlow"
    ) , array(
	"fontFamily" => "Barlow Condensed",
	"name" => "Barlow Condensed",
	"slug" => "barlow-condensed"
    ) , array(
	"fontFamily" => "Barlow Semi Condensed",
	"name" => "Barlow Semi Condensed",
	"slug" => "barlow-semi-condensed"
    ) , array(
	"fontFamily" => "Barriecito",
	"name" => "Barriecito",
	"slug" => "barriecito"
    ) , array(
	"fontFamily" => "Barrio",
	"name" => "Barrio",
	"slug" => "barrio"
    ) , array(
	"fontFamily" => "Basic",
	"name" => "Basic",
	"slug" => "basic"
    ) , array(
	"fontFamily" => "Baskervville",
	"name" => "Baskervville",
	"slug" => "baskervville"
    ) , array(
	"fontFamily" => "Battambang",
	"name" => "Battambang",
	"slug" => "battambang"
    ) , array(
	"fontFamily" => "Baumans",
	"name" => "Baumans",
	"slug" => "baumans"
    ) , array(
	"fontFamily" => "Bayon",
	"name" => "Bayon",
	"slug" => "bayon"
    ) , array(
	"fontFamily" => "Be Vietnam Pro",
	"name" => "Be Vietnam Pro",
	"slug" => "be-vietnam-pro"
    ) , array(
	"fontFamily" => "Bebas Neue",
	"name" => "Bebas Neue",
	"slug" => "bebas-neue"
    ) , array(
	"fontFamily" => "Belgrano",
	"name" => "Belgrano",
	"slug" => "belgrano"
    ) , array(
	"fontFamily" => "Bellefair",
	"name" => "Bellefair",
	"slug" => "bellefair"
    ) , array(
	"fontFamily" => "Belleza",
	"name" => "Belleza",
	"slug" => "belleza"
    ) , array(
	"fontFamily" => "Bellota",
	"name" => "Bellota",
	"slug" => "bellota"
    ) , array(
	"fontFamily" => "Bellota Text",
	"name" => "Bellota Text",
	"slug" => "bellota-text"
    ) , array(
	"fontFamily" => "BenchNine",
	"name" => "BenchNine",
	"slug" => "benchnine"
    ) , array(
	"fontFamily" => "Benne",
	"name" => "Benne",
	"slug" => "benne"
    ) , array(
	"fontFamily" => "Bentham",
	"name" => "Bentham",
	"slug" => "bentham"
    ) , array(
	"fontFamily" => "Berkshire Swash",
	"name" => "Berkshire Swash",
	"slug" => "berkshire-swash"
    ) , array(
	"fontFamily" => "Besley",
	"name" => "Besley",
	"slug" => "besley"
    ) , array(
	"fontFamily" => "Beth Ellen",
	"name" => "Beth Ellen",
	"slug" => "beth-ellen"
    ) , array(
	"fontFamily" => "Bevan",
	"name" => "Bevan",
	"slug" => "bevan"
    ) , array(
	"fontFamily" => "Big Shoulders Display",
	"name" => "Big Shoulders Display",
	"slug" => "big-shoulders-display"
    ) , array(
	"fontFamily" => "Big Shoulders Inline Display",
	"name" => "Big Shoulders Inline Display",
	"slug" => "big-shoulders-inline-display"
    ) , array(
	"fontFamily" => "Big Shoulders Inline Text",
	"name" => "Big Shoulders Inline Text",
	"slug" => "big-shoulders-inline-text"
    ) , array(
	"fontFamily" => "Big Shoulders Stencil Display",
	"name" => "Big Shoulders Stencil Display",
	"slug" => "big-shoulders-stencil-display"
    ) , array(
	"fontFamily" => "Big Shoulders Stencil Text",
	"name" => "Big Shoulders Stencil Text",
	"slug" => "big-shoulders-stencil-text"
    ) , array(
	"fontFamily" => "Big Shoulders Text",
	"name" => "Big Shoulders Text",
	"slug" => "big-shoulders-text"
    ) , array(
	"fontFamily" => "Bigelow Rules",
	"name" => "Bigelow Rules",
	"slug" => "bigelow-rules"
    ) , array(
	"fontFamily" => "Bigshot One",
	"name" => "Bigshot One",
	"slug" => "bigshot-one"
    ) , array(
	"fontFamily" => "Bilbo",
	"name" => "Bilbo",
	"slug" => "bilbo"
    ) , array(
	"fontFamily" => "Bilbo Swash Caps",
	"name" => "Bilbo Swash Caps",
	"slug" => "bilbo-swash-caps"
    ) , array(
	"fontFamily" => "BioRhyme",
	"name" => "BioRhyme",
	"slug" => "biorhyme"
    ) , array(
	"fontFamily" => "BioRhyme Expanded",
	"name" => "BioRhyme Expanded",
	"slug" => "biorhyme-expanded"
    ) , array(
	"fontFamily" => "Birthstone",
	"name" => "Birthstone",
	"slug" => "birthstone"
    ) , array(
	"fontFamily" => "Birthstone Bounce",
	"name" => "Birthstone Bounce",
	"slug" => "birthstone-bounce"
    ) , array(
	"fontFamily" => "Biryani",
	"name" => "Biryani",
	"slug" => "biryani"
    ) , array(
	"fontFamily" => "Bitter",
	"name" => "Bitter",
	"slug" => "bitter"
    ) , array(
	"fontFamily" => "Black And White Picture",
	"name" => "Black And White Picture",
	"slug" => "black-and-white-picture"
    ) , array(
	"fontFamily" => "Black Han Sans",
	"name" => "Black Han Sans",
	"slug" => "black-han-sans"
    ) , array(
	"fontFamily" => "Black Ops One",
	"name" => "Black Ops One",
	"slug" => "black-ops-one"
    ) , array(
	"fontFamily" => "Blinker",
	"name" => "Blinker",
	"slug" => "blinker"
    ) , array(
	"fontFamily" => "Bodoni Moda",
	"name" => "Bodoni Moda",
	"slug" => "bodoni-moda"
    ) , array(
	"fontFamily" => "Bokor",
	"name" => "Bokor",
	"slug" => "bokor"
    ) , array(
	"fontFamily" => "Bona Nova",
	"name" => "Bona Nova",
	"slug" => "bona-nova"
    ) , array(
	"fontFamily" => "Bonbon",
	"name" => "Bonbon",
	"slug" => "bonbon"
    ) , array(
	"fontFamily" => "Bonheur Royale",
	"name" => "Bonheur Royale",
	"slug" => "bonheur-royale"
    ) , array(
	"fontFamily" => "Boogaloo",
	"name" => "Boogaloo",
	"slug" => "boogaloo"
    ) , array(
	"fontFamily" => "Bowlby One",
	"name" => "Bowlby One",
	"slug" => "bowlby-one"
    ) , array(
	"fontFamily" => "Bowlby One SC",
	"name" => "Bowlby One SC",
	"slug" => "bowlby-one-sc"
    ) , array(
	"fontFamily" => "Brawler",
	"name" => "Brawler",
	"slug" => "brawler"
    ) , array(
	"fontFamily" => "Bree Serif",
	"name" => "Bree Serif",
	"slug" => "bree-serif"
    ) , array(
	"fontFamily" => "Brygada 1918",
	"name" => "Brygada 1918",
	"slug" => "brygada-1918"
    ) , array(
	"fontFamily" => "Bubblegum Sans",
	"name" => "Bubblegum Sans",
	"slug" => "bubblegum-sans"
    ) , array(
	"fontFamily" => "Bubbler One",
	"name" => "Bubbler One",
	"slug" => "bubbler-one"
    ) , array(
	"fontFamily" => "Buda",
	"name" => "Buda",
	"slug" => "buda"
    ) , array(
	"fontFamily" => "Buenard",
	"name" => "Buenard",
	"slug" => "buenard"
    ) , array(
	"fontFamily" => "Bungee",
	"name" => "Bungee",
	"slug" => "bungee"
    ) , array(
	"fontFamily" => "Bungee Hairline",
	"name" => "Bungee Hairline",
	"slug" => "bungee-hairline"
    ) , array(
	"fontFamily" => "Bungee Inline",
	"name" => "Bungee Inline",
	"slug" => "bungee-inline"
    ) , array(
	"fontFamily" => "Bungee Outline",
	"name" => "Bungee Outline",
	"slug" => "bungee-outline"
    ) , array(
	"fontFamily" => "Bungee Shade",
	"name" => "Bungee Shade",
	"slug" => "bungee-shade"
    ) , array(
	"fontFamily" => "Butcherman",
	"name" => "Butcherman",
	"slug" => "butcherman"
    ) , array(
	"fontFamily" => "Butterfly Kids",
	"name" => "Butterfly Kids",
	"slug" => "butterfly-kids"
    ) , array(
	"fontFamily" => "Cabin",
	"name" => "Cabin",
	"slug" => "cabin"
    ) , array(
	"fontFamily" => "Cabin Condensed",
	"name" => "Cabin Condensed",
	"slug" => "cabin-condensed"
    ) , array(
	"fontFamily" => "Cabin Sketch",
	"name" => "Cabin Sketch",
	"slug" => "cabin-sketch"
    ) , array(
	"fontFamily" => "Caesar Dressing",
	"name" => "Caesar Dressing",
	"slug" => "caesar-dressing"
    ) , array(
	"fontFamily" => "Cagliostro",
	"name" => "Cagliostro",
	"slug" => "cagliostro"
    ) , array(
	"fontFamily" => "Cairo",
	"name" => "Cairo",
	"slug" => "cairo"
    ) , array(
	"fontFamily" => "Caladea",
	"name" => "Caladea",
	"slug" => "caladea"
    ) , array(
	"fontFamily" => "Calistoga",
	"name" => "Calistoga",
	"slug" => "calistoga"
    ) , array(
	"fontFamily" => "Calligraffitti",
	"name" => "Calligraffitti",
	"slug" => "calligraffitti"
    ) , array(
	"fontFamily" => "Cambay",
	"name" => "Cambay",
	"slug" => "cambay"
    ) , array(
	"fontFamily" => "Cambo",
	"name" => "Cambo",
	"slug" => "cambo"
    ) , array(
	"fontFamily" => "Candal",
	"name" => "Candal",
	"slug" => "candal"
    ) , array(
	"fontFamily" => "Cantarell",
	"name" => "Cantarell",
	"slug" => "cantarell"
    ) , array(
	"fontFamily" => "Cantata One",
	"name" => "Cantata One",
	"slug" => "cantata-one"
    ) , array(
	"fontFamily" => "Cantora One",
	"name" => "Cantora One",
	"slug" => "cantora-one"
    ) , array(
	"fontFamily" => "Capriola",
	"name" => "Capriola",
	"slug" => "capriola"
    ) , array(
	"fontFamily" => "Caramel",
	"name" => "Caramel",
	"slug" => "caramel"
    ) , array(
	"fontFamily" => "Carattere",
	"name" => "Carattere",
	"slug" => "carattere"
    ) , array(
	"fontFamily" => "Cardo",
	"name" => "Cardo",
	"slug" => "cardo"
    ) , array(
	"fontFamily" => "Carme",
	"name" => "Carme",
	"slug" => "carme"
    ) , array(
	"fontFamily" => "Carrois Gothic",
	"name" => "Carrois Gothic",
	"slug" => "carrois-gothic"
    ) , array(
	"fontFamily" => "Carrois Gothic SC",
	"name" => "Carrois Gothic SC",
	"slug" => "carrois-gothic-sc"
    ) , array(
	"fontFamily" => "Carter One",
	"name" => "Carter One",
	"slug" => "carter-one"
    ) , array(
	"fontFamily" => "Castoro",
	"name" => "Castoro",
	"slug" => "castoro"
    ) , array(
	"fontFamily" => "Catamaran",
	"name" => "Catamaran",
	"slug" => "catamaran"
    ) , array(
	"fontFamily" => "Caudex",
	"name" => "Caudex",
	"slug" => "caudex"
    ) , array(
	"fontFamily" => "Caveat",
	"name" => "Caveat",
	"slug" => "caveat"
    ) , array(
	"fontFamily" => "Caveat Brush",
	"name" => "Caveat Brush",
	"slug" => "caveat-brush"
    ) , array(
	"fontFamily" => "Cedarville Cursive",
	"name" => "Cedarville Cursive",
	"slug" => "cedarville-cursive"
    ) , array(
	"fontFamily" => "Ceviche One",
	"name" => "Ceviche One",
	"slug" => "ceviche-one"
    ) , array(
	"fontFamily" => "Chakra Petch",
	"name" => "Chakra Petch",
	"slug" => "chakra-petch"
    ) , array(
	"fontFamily" => "Changa",
	"name" => "Changa",
	"slug" => "changa"
    ) , array(
	"fontFamily" => "Changa One",
	"name" => "Changa One",
	"slug" => "changa-one"
    ) , array(
	"fontFamily" => "Chango",
	"name" => "Chango",
	"slug" => "chango"
    ) , array(
	"fontFamily" => "Charm",
	"name" => "Charm",
	"slug" => "charm"
    ) , array(
	"fontFamily" => "Charmonman",
	"name" => "Charmonman",
	"slug" => "charmonman"
    ) , array(
	"fontFamily" => "Chathura",
	"name" => "Chathura",
	"slug" => "chathura"
    ) , array(
	"fontFamily" => "Chau Philomene One",
	"name" => "Chau Philomene One",
	"slug" => "chau-philomene-one"
    ) , array(
	"fontFamily" => "Chela One",
	"name" => "Chela One",
	"slug" => "chela-one"
    ) , array(
	"fontFamily" => "Chelsea Market",
	"name" => "Chelsea Market",
	"slug" => "chelsea-market"
    ) , array(
	"fontFamily" => "Chenla",
	"name" => "Chenla",
	"slug" => "chenla"
    ) , array(
	"fontFamily" => "Cherish",
	"name" => "Cherish",
	"slug" => "cherish"
    ) , array(
	"fontFamily" => "Cherry Cream Soda",
	"name" => "Cherry Cream Soda",
	"slug" => "cherry-cream-soda"
    ) , array(
	"fontFamily" => "Cherry Swash",
	"name" => "Cherry Swash",
	"slug" => "cherry-swash"
    ) , array(
	"fontFamily" => "Chewy",
	"name" => "Chewy",
	"slug" => "chewy"
    ) , array(
	"fontFamily" => "Chicle",
	"name" => "Chicle",
	"slug" => "chicle"
    ) , array(
	"fontFamily" => "Chilanka",
	"name" => "Chilanka",
	"slug" => "chilanka"
    ) , array(
	"fontFamily" => "Chivo",
	"name" => "Chivo",
	"slug" => "chivo"
    ) , array(
	"fontFamily" => "Chonburi",
	"name" => "Chonburi",
	"slug" => "chonburi"
    ) , array(
	"fontFamily" => "Cinzel",
	"name" => "Cinzel",
	"slug" => "cinzel"
    ) , array(
	"fontFamily" => "Cinzel Decorative",
	"name" => "Cinzel Decorative",
	"slug" => "cinzel-decorative"
    ) , array(
	"fontFamily" => "Clicker Script",
	"name" => "Clicker Script",
	"slug" => "clicker-script"
    ) , array(
	"fontFamily" => "Coda",
	"name" => "Coda",
	"slug" => "coda"
    ) , array(
	"fontFamily" => "Coda Caption",
	"name" => "Coda Caption",
	"slug" => "coda-caption"
    ) , array(
	"fontFamily" => "Codystar",
	"name" => "Codystar",
	"slug" => "codystar"
    ) , array(
	"fontFamily" => "Coiny",
	"name" => "Coiny",
	"slug" => "coiny"
    ) , array(
	"fontFamily" => "Combo",
	"name" => "Combo",
	"slug" => "combo"
    ) , array(
	"fontFamily" => "Comfortaa",
	"name" => "Comfortaa",
	"slug" => "comfortaa"
    ) , array(
	"fontFamily" => "Comforter",
	"name" => "Comforter",
	"slug" => "comforter"
    ) , array(
	"fontFamily" => "Comforter Brush",
	"name" => "Comforter Brush",
	"slug" => "comforter-brush"
    ) , array(
	"fontFamily" => "Comic Neue",
	"name" => "Comic Neue",
	"slug" => "comic-neue"
    ) , array(
	"fontFamily" => "Coming Soon",
	"name" => "Coming Soon",
	"slug" => "coming-soon"
    ) , array(
	"fontFamily" => "Commissioner",
	"name" => "Commissioner",
	"slug" => "commissioner"
    ) , array(
	"fontFamily" => "Concert One",
	"name" => "Concert One",
	"slug" => "concert-one"
    ) , array(
	"fontFamily" => "Condiment",
	"name" => "Condiment",
	"slug" => "condiment"
    ) , array(
	"fontFamily" => "Content",
	"name" => "Content",
	"slug" => "content"
    ) , array(
	"fontFamily" => "Contrail One",
	"name" => "Contrail One",
	"slug" => "contrail-one"
    ) , array(
	"fontFamily" => "Convergence",
	"name" => "Convergence",
	"slug" => "convergence"
    ) , array(
	"fontFamily" => "Cookie",
	"name" => "Cookie",
	"slug" => "cookie"
    ) , array(
	"fontFamily" => "Copse",
	"name" => "Copse",
	"slug" => "copse"
    ) , array(
	"fontFamily" => "Corben",
	"name" => "Corben",
	"slug" => "corben"
    ) , array(
	"fontFamily" => "Corinthia",
	"name" => "Corinthia",
	"slug" => "corinthia"
    ) , array(
	"fontFamily" => "Cormorant",
	"name" => "Cormorant",
	"slug" => "cormorant"
    ) , array(
	"fontFamily" => "Cormorant Garamond",
	"name" => "Cormorant Garamond",
	"slug" => "cormorant-garamond"
    ) , array(
	"fontFamily" => "Cormorant Infant",
	"name" => "Cormorant Infant",
	"slug" => "cormorant-infant"
    ) , array(
	"fontFamily" => "Cormorant SC",
	"name" => "Cormorant SC",
	"slug" => "cormorant-sc"
    ) , array(
	"fontFamily" => "Cormorant Unicase",
	"name" => "Cormorant Unicase",
	"slug" => "cormorant-unicase"
    ) , array(
	"fontFamily" => "Cormorant Upright",
	"name" => "Cormorant Upright",
	"slug" => "cormorant-upright"
    ) , array(
	"fontFamily" => "Courgette",
	"name" => "Courgette",
	"slug" => "courgette"
    ) , array(
	"fontFamily" => "Courier Prime",
	"name" => "Courier Prime",
	"slug" => "courier-prime"
    ) , array(
	"fontFamily" => "Cousine",
	"name" => "Cousine",
	"slug" => "cousine"
    ) , array(
	"fontFamily" => "Coustard",
	"name" => "Coustard",
	"slug" => "coustard"
    ) , array(
	"fontFamily" => "Covered By Your Grace",
	"name" => "Covered By Your Grace",
	"slug" => "covered-by-your-grace"
    ) , array(
	"fontFamily" => "Crafty Girls",
	"name" => "Crafty Girls",
	"slug" => "crafty-girls"
    ) , array(
	"fontFamily" => "Creepster",
	"name" => "Creepster",
	"slug" => "creepster"
    ) , array(
	"fontFamily" => "Crete Round",
	"name" => "Crete Round",
	"slug" => "crete-round"
    ) , array(
	"fontFamily" => "Crimson Pro",
	"name" => "Crimson Pro",
	"slug" => "crimson-pro"
    ) , array(
	"fontFamily" => "Croissant One",
	"name" => "Croissant One",
	"slug" => "croissant-one"
    ) , array(
	"fontFamily" => "Crushed",
	"name" => "Crushed",
	"slug" => "crushed"
    ) , array(
	"fontFamily" => "Cuprum",
	"name" => "Cuprum",
	"slug" => "cuprum"
    ) , array(
	"fontFamily" => "Cute Font",
	"name" => "Cute Font",
	"slug" => "cute-font"
    ) , array(
	"fontFamily" => "Cutive",
	"name" => "Cutive",
	"slug" => "cutive"
    ) , array(
	"fontFamily" => "Cutive Mono",
	"name" => "Cutive Mono",
	"slug" => "cutive-mono"
    ) , array(
	"fontFamily" => "DM Mono",
	"name" => "DM Mono",
	"slug" => "dm-mono"
    ) , array(
	"fontFamily" => "DM Sans",
	"name" => "DM Sans",
	"slug" => "dm-sans"
    ) , array(
	"fontFamily" => "DM Serif Display",
	"name" => "DM Serif Display",
	"slug" => "dm-serif-display"
    ) , array(
	"fontFamily" => "DM Serif Text",
	"name" => "DM Serif Text",
	"slug" => "dm-serif-text"
    ) , array(
	"fontFamily" => "Damion",
	"name" => "Damion",
	"slug" => "damion"
    ) , array(
	"fontFamily" => "Dancing Script",
	"name" => "Dancing Script",
	"slug" => "dancing-script"
    ) , array(
	"fontFamily" => "Dangrek",
	"name" => "Dangrek",
	"slug" => "dangrek"
    ) , array(
	"fontFamily" => "Darker Grotesque",
	"name" => "Darker Grotesque",
	"slug" => "darker-grotesque"
    ) , array(
	"fontFamily" => "David Libre",
	"name" => "David Libre",
	"slug" => "david-libre"
    ) , array(
	"fontFamily" => "Dawning of a New Day",
	"name" => "Dawning of a New Day",
	"slug" => "dawning-of-a-new-day"
    ) , array(
	"fontFamily" => "Days One",
	"name" => "Days One",
	"slug" => "days-one"
    ) , array(
	"fontFamily" => "Dekko",
	"name" => "Dekko",
	"slug" => "dekko"
    ) , array(
	"fontFamily" => "Dela Gothic One",
	"name" => "Dela Gothic One",
	"slug" => "dela-gothic-one"
    ) , array(
	"fontFamily" => "Delius",
	"name" => "Delius",
	"slug" => "delius"
    ) , array(
	"fontFamily" => "Delius Swash Caps",
	"name" => "Delius Swash Caps",
	"slug" => "delius-swash-caps"
    ) , array(
	"fontFamily" => "Delius Unicase",
	"name" => "Delius Unicase",
	"slug" => "delius-unicase"
    ) , array(
	"fontFamily" => "Della Respira",
	"name" => "Della Respira",
	"slug" => "della-respira"
    ) , array(
	"fontFamily" => "Denk One",
	"name" => "Denk One",
	"slug" => "denk-one"
    ) , array(
	"fontFamily" => "Devonshire",
	"name" => "Devonshire",
	"slug" => "devonshire"
    ) , array(
	"fontFamily" => "Dhurjati",
	"name" => "Dhurjati",
	"slug" => "dhurjati"
    ) , array(
	"fontFamily" => "Didact Gothic",
	"name" => "Didact Gothic",
	"slug" => "didact-gothic"
    ) , array(
	"fontFamily" => "Diplomata",
	"name" => "Diplomata",
	"slug" => "diplomata"
    ) , array(
	"fontFamily" => "Diplomata SC",
	"name" => "Diplomata SC",
	"slug" => "diplomata-sc"
    ) , array(
	"fontFamily" => "Do Hyeon",
	"name" => "Do Hyeon",
	"slug" => "do-hyeon"
    ) , array(
	"fontFamily" => "Dokdo",
	"name" => "Dokdo",
	"slug" => "dokdo"
    ) , array(
	"fontFamily" => "Domine",
	"name" => "Domine",
	"slug" => "domine"
    ) , array(
	"fontFamily" => "Donegal One",
	"name" => "Donegal One",
	"slug" => "donegal-one"
    ) , array(
	"fontFamily" => "Dongle",
	"name" => "Dongle",
	"slug" => "dongle"
    ) , array(
	"fontFamily" => "Doppio One",
	"name" => "Doppio One",
	"slug" => "doppio-one"
    ) , array(
	"fontFamily" => "Dorsa",
	"name" => "Dorsa",
	"slug" => "dorsa"
    ) , array(
	"fontFamily" => "Dosis",
	"name" => "Dosis",
	"slug" => "dosis"
    ) , array(
	"fontFamily" => "DotGothic16",
	"name" => "DotGothic16",
	"slug" => "dotgothic16"
    ) , array(
	"fontFamily" => "Dr Sugiyama",
	"name" => "Dr Sugiyama",
	"slug" => "dr-sugiyama"
    ) , array(
	"fontFamily" => "Duru Sans",
	"name" => "Duru Sans",
	"slug" => "duru-sans"
    ) , array(
	"fontFamily" => "Dynalight",
	"name" => "Dynalight",
	"slug" => "dynalight"
    ) , array(
	"fontFamily" => "EB Garamond",
	"name" => "EB Garamond",
	"slug" => "eb-garamond"
    ) , array(
	"fontFamily" => "Eagle Lake",
	"name" => "Eagle Lake",
	"slug" => "eagle-lake"
    ) , array(
	"fontFamily" => "East Sea Dokdo",
	"name" => "East Sea Dokdo",
	"slug" => "east-sea-dokdo"
    ) , array(
	"fontFamily" => "Eater",
	"name" => "Eater",
	"slug" => "eater"
    ) , array(
	"fontFamily" => "Economica",
	"name" => "Economica",
	"slug" => "economica"
    ) , array(
	"fontFamily" => "Eczar",
	"name" => "Eczar",
	"slug" => "eczar"
    ) , array(
	"fontFamily" => "El Messiri",
	"name" => "El Messiri",
	"slug" => "el-messiri"
    ) , array(
	"fontFamily" => "Electrolize",
	"name" => "Electrolize",
	"slug" => "electrolize"
    ) , array(
	"fontFamily" => "Elsie",
	"name" => "Elsie",
	"slug" => "elsie"
    ) , array(
	"fontFamily" => "Elsie Swash Caps",
	"name" => "Elsie Swash Caps",
	"slug" => "elsie-swash-caps"
    ) , array(
	"fontFamily" => "Emblema One",
	"name" => "Emblema One",
	"slug" => "emblema-one"
    ) , array(
	"fontFamily" => "Emilys Candy",
	"name" => "Emilys Candy",
	"slug" => "emilys-candy"
    ) , array(
	"fontFamily" => "Encode Sans",
	"name" => "Encode Sans",
	"slug" => "encode-sans"
    ) , array(
	"fontFamily" => "Encode Sans Condensed",
	"name" => "Encode Sans Condensed",
	"slug" => "encode-sans-condensed"
    ) , array(
	"fontFamily" => "Encode Sans Expanded",
	"name" => "Encode Sans Expanded",
	"slug" => "encode-sans-expanded"
    ) , array(
	"fontFamily" => "Encode Sans SC",
	"name" => "Encode Sans SC",
	"slug" => "encode-sans-sc"
    ) , array(
	"fontFamily" => "Encode Sans Semi Condensed",
	"name" => "Encode Sans Semi Condensed",
	"slug" => "encode-sans-semi-condensed"
    ) , array(
	"fontFamily" => "Encode Sans Semi Expanded",
	"name" => "Encode Sans Semi Expanded",
	"slug" => "encode-sans-semi-expanded"
    ) , array(
	"fontFamily" => "Engagement",
	"name" => "Engagement",
	"slug" => "engagement"
    ) , array(
	"fontFamily" => "Englebert",
	"name" => "Englebert",
	"slug" => "englebert"
    ) , array(
	"fontFamily" => "Enriqueta",
	"name" => "Enriqueta",
	"slug" => "enriqueta"
    ) , array(
	"fontFamily" => "Ephesis",
	"name" => "Ephesis",
	"slug" => "ephesis"
    ) , array(
	"fontFamily" => "Epilogue",
	"name" => "Epilogue",
	"slug" => "epilogue"
    ) , array(
	"fontFamily" => "Erica One",
	"name" => "Erica One",
	"slug" => "erica-one"
    ) , array(
	"fontFamily" => "Esteban",
	"name" => "Esteban",
	"slug" => "esteban"
    ) , array(
	"fontFamily" => "Estonia",
	"name" => "Estonia",
	"slug" => "estonia"
    ) , array(
	"fontFamily" => "Euphoria Script",
	"name" => "Euphoria Script",
	"slug" => "euphoria-script"
    ) , array(
	"fontFamily" => "Ewert",
	"name" => "Ewert",
	"slug" => "ewert"
    ) , array(
	"fontFamily" => "Exo",
	"name" => "Exo",
	"slug" => "exo"
    ) , array(
	"fontFamily" => "Exo 2",
	"name" => "Exo 2",
	"slug" => "exo-2"
    ) , array(
	"fontFamily" => "Expletus Sans",
	"name" => "Expletus Sans",
	"slug" => "expletus-sans"
    ) , array(
	"fontFamily" => "Explora",
	"name" => "Explora",
	"slug" => "explora"
    ) , array(
	"fontFamily" => "Fahkwang",
	"name" => "Fahkwang",
	"slug" => "fahkwang"
    ) , array(
	"fontFamily" => "Fanwood Text",
	"name" => "Fanwood Text",
	"slug" => "fanwood-text"
    ) , array(
	"fontFamily" => "Farro",
	"name" => "Farro",
	"slug" => "farro"
    ) , array(
	"fontFamily" => "Farsan",
	"name" => "Farsan",
	"slug" => "farsan"
    ) , array(
	"fontFamily" => "Fascinate",
	"name" => "Fascinate",
	"slug" => "fascinate"
    ) , array(
	"fontFamily" => "Fascinate Inline",
	"name" => "Fascinate Inline",
	"slug" => "fascinate-inline"
    ) , array(
	"fontFamily" => "Faster One",
	"name" => "Faster One",
	"slug" => "faster-one"
    ) , array(
	"fontFamily" => "Fasthand",
	"name" => "Fasthand",
	"slug" => "fasthand"
    ) , array(
	"fontFamily" => "Fauna One",
	"name" => "Fauna One",
	"slug" => "fauna-one"
    ) , array(
	"fontFamily" => "Faustina",
	"name" => "Faustina",
	"slug" => "faustina"
    ) , array(
	"fontFamily" => "Federant",
	"name" => "Federant",
	"slug" => "federant"
    ) , array(
	"fontFamily" => "Federo",
	"name" => "Federo",
	"slug" => "federo"
    ) , array(
	"fontFamily" => "Felipa",
	"name" => "Felipa",
	"slug" => "felipa"
    ) , array(
	"fontFamily" => "Fenix",
	"name" => "Fenix",
	"slug" => "fenix"
    ) , array(
	"fontFamily" => "Festive",
	"name" => "Festive",
	"slug" => "festive"
    ) , array(
	"fontFamily" => "Finger Paint",
	"name" => "Finger Paint",
	"slug" => "finger-paint"
    ) , array(
	"fontFamily" => "Fira Code",
	"name" => "Fira Code",
	"slug" => "fira-code"
    ) , array(
	"fontFamily" => "Fira Mono",
	"name" => "Fira Mono",
	"slug" => "fira-mono"
    ) , array(
	"fontFamily" => "Fira Sans",
	"name" => "Fira Sans",
	"slug" => "fira-sans"
    ) , array(
	"fontFamily" => "Fira Sans Condensed",
	"name" => "Fira Sans Condensed",
	"slug" => "fira-sans-condensed"
    ) , array(
	"fontFamily" => "Fira Sans Extra Condensed",
	"name" => "Fira Sans Extra Condensed",
	"slug" => "fira-sans-extra-condensed"
    ) , array(
	"fontFamily" => "Fjalla One",
	"name" => "Fjalla One",
	"slug" => "fjalla-one"
    ) , array(
	"fontFamily" => "Fjord One",
	"name" => "Fjord One",
	"slug" => "fjord-one"
    ) , array(
	"fontFamily" => "Flamenco",
	"name" => "Flamenco",
	"slug" => "flamenco"
    ) , array(
	"fontFamily" => "Flavors",
	"name" => "Flavors",
	"slug" => "flavors"
    ) , array(
	"fontFamily" => "Fleur De Leah",
	"name" => "Fleur De Leah",
	"slug" => "fleur-de-leah"
    ) , array(
	"fontFamily" => "Flow Block",
	"name" => "Flow Block",
	"slug" => "flow-block"
    ) , array(
	"fontFamily" => "Flow Circular",
	"name" => "Flow Circular",
	"slug" => "flow-circular"
    ) , array(
	"fontFamily" => "Flow Rounded",
	"name" => "Flow Rounded",
	"slug" => "flow-rounded"
    ) , array(
	"fontFamily" => "Fondamento",
	"name" => "Fondamento",
	"slug" => "fondamento"
    ) , array(
	"fontFamily" => "Fontdiner Swanky",
	"name" => "Fontdiner Swanky",
	"slug" => "fontdiner-swanky"
    ) , array(
	"fontFamily" => "Forum",
	"name" => "Forum",
	"slug" => "forum"
    ) , array(
	"fontFamily" => "Francois One",
	"name" => "Francois One",
	"slug" => "francois-one"
    ) , array(
	"fontFamily" => "Frank Ruhl Libre",
	"name" => "Frank Ruhl Libre",
	"slug" => "frank-ruhl-libre"
    ) , array(
	"fontFamily" => "Fraunces",
	"name" => "Fraunces",
	"slug" => "fraunces"
    ) , array(
	"fontFamily" => "Freckle Face",
	"name" => "Freckle Face",
	"slug" => "freckle-face"
    ) , array(
	"fontFamily" => "Fredericka the Great",
	"name" => "Fredericka the Great",
	"slug" => "fredericka-the-great"
    ) , array(
	"fontFamily" => "Fredoka One",
	"name" => "Fredoka One",
	"slug" => "fredoka-one"
    ) , array(
	"fontFamily" => "Freehand",
	"name" => "Freehand",
	"slug" => "freehand"
    ) , array(
	"fontFamily" => "Fresca",
	"name" => "Fresca",
	"slug" => "fresca"
    ) , array(
	"fontFamily" => "Frijole",
	"name" => "Frijole",
	"slug" => "frijole"
    ) , array(
	"fontFamily" => "Fruktur",
	"name" => "Fruktur",
	"slug" => "fruktur"
    ) , array(
	"fontFamily" => "Fugaz One",
	"name" => "Fugaz One",
	"slug" => "fugaz-one"
    ) , array(
	"fontFamily" => "Fuggles",
	"name" => "Fuggles",
	"slug" => "fuggles"
    ) , array(
	"fontFamily" => "Fuzzy Bubbles",
	"name" => "Fuzzy Bubbles",
	"slug" => "fuzzy-bubbles"
    ) , array(
	"fontFamily" => "GFS Didot",
	"name" => "GFS Didot",
	"slug" => "gfs-didot"
    ) , array(
	"fontFamily" => "GFS Neohellenic",
	"name" => "GFS Neohellenic",
	"slug" => "gfs-neohellenic"
    ) , array(
	"fontFamily" => "Gabriela",
	"name" => "Gabriela",
	"slug" => "gabriela"
    ) , array(
	"fontFamily" => "Gaegu",
	"name" => "Gaegu",
	"slug" => "gaegu"
    ) , array(
	"fontFamily" => "Gafata",
	"name" => "Gafata",
	"slug" => "gafata"
    ) , array(
	"fontFamily" => "Galada",
	"name" => "Galada",
	"slug" => "galada"
    ) , array(
	"fontFamily" => "Galdeano",
	"name" => "Galdeano",
	"slug" => "galdeano"
    ) , array(
	"fontFamily" => "Galindo",
	"name" => "Galindo",
	"slug" => "galindo"
    ) , array(
	"fontFamily" => "Gamja Flower",
	"name" => "Gamja Flower",
	"slug" => "gamja-flower"
    ) , array(
	"fontFamily" => "Gayathri",
	"name" => "Gayathri",
	"slug" => "gayathri"
    ) , array(
	"fontFamily" => "Gelasio",
	"name" => "Gelasio",
	"slug" => "gelasio"
    ) , array(
	"fontFamily" => "Gemunu Libre",
	"name" => "Gemunu Libre",
	"slug" => "gemunu-libre"
    ) , array(
	"fontFamily" => "Genos",
	"name" => "Genos",
	"slug" => "genos"
    ) , array(
	"fontFamily" => "Gentium Basic",
	"name" => "Gentium Basic",
	"slug" => "gentium-basic"
    ) , array(
	"fontFamily" => "Gentium Book Basic",
	"name" => "Gentium Book Basic",
	"slug" => "gentium-book-basic"
    ) , array(
	"fontFamily" => "Geo",
	"name" => "Geo",
	"slug" => "geo"
    ) , array(
	"fontFamily" => "Georama",
	"name" => "Georama",
	"slug" => "georama"
    ) , array(
	"fontFamily" => "Geostar",
	"name" => "Geostar",
	"slug" => "geostar"
    ) , array(
	"fontFamily" => "Geostar Fill",
	"name" => "Geostar Fill",
	"slug" => "geostar-fill"
    ) , array(
	"fontFamily" => "Germania One",
	"name" => "Germania One",
	"slug" => "germania-one"
    ) , array(
	"fontFamily" => "Gideon Roman",
	"name" => "Gideon Roman",
	"slug" => "gideon-roman"
    ) , array(
	"fontFamily" => "Gidugu",
	"name" => "Gidugu",
	"slug" => "gidugu"
    ) , array(
	"fontFamily" => "Gilda Display",
	"name" => "Gilda Display",
	"slug" => "gilda-display"
    ) , array(
	"fontFamily" => "Girassol",
	"name" => "Girassol",
	"slug" => "girassol"
    ) , array(
	"fontFamily" => "Give You Glory",
	"name" => "Give You Glory",
	"slug" => "give-you-glory"
    ) , array(
	"fontFamily" => "Glass Antiqua",
	"name" => "Glass Antiqua",
	"slug" => "glass-antiqua"
    ) , array(
	"fontFamily" => "Glegoo",
	"name" => "Glegoo",
	"slug" => "glegoo"
    ) , array(
	"fontFamily" => "Gloria Hallelujah",
	"name" => "Gloria Hallelujah",
	"slug" => "gloria-hallelujah"
    ) , array(
	"fontFamily" => "Glory",
	"name" => "Glory",
	"slug" => "glory"
    ) , array(
	"fontFamily" => "Gluten",
	"name" => "Gluten",
	"slug" => "gluten"
    ) , array(
	"fontFamily" => "Goblin One",
	"name" => "Goblin One",
	"slug" => "goblin-one"
    ) , array(
	"fontFamily" => "Gochi Hand",
	"name" => "Gochi Hand",
	"slug" => "gochi-hand"
    ) , array(
	"fontFamily" => "Goldman",
	"name" => "Goldman",
	"slug" => "goldman"
    ) , array(
	"fontFamily" => "Gorditas",
	"name" => "Gorditas",
	"slug" => "gorditas"
    ) , array(
	"fontFamily" => "Gothic A1",
	"name" => "Gothic A1",
	"slug" => "gothic-a1"
    ) , array(
	"fontFamily" => "Gotu",
	"name" => "Gotu",
	"slug" => "gotu"
    ) , array(
	"fontFamily" => "Goudy Bookletter 1911",
	"name" => "Goudy Bookletter 1911",
	"slug" => "goudy-bookletter-1911"
    ) , array(
	"fontFamily" => "Gowun Batang",
	"name" => "Gowun Batang",
	"slug" => "gowun-batang"
    ) , array(
	"fontFamily" => "Gowun Dodum",
	"name" => "Gowun Dodum",
	"slug" => "gowun-dodum"
    ) , array(
	"fontFamily" => "Graduate",
	"name" => "Graduate",
	"slug" => "graduate"
    ) , array(
	"fontFamily" => "Grand Hotel",
	"name" => "Grand Hotel",
	"slug" => "grand-hotel"
    ) , array(
	"fontFamily" => "Grandstander",
	"name" => "Grandstander",
	"slug" => "grandstander"
    ) , array(
	"fontFamily" => "Gravitas One",
	"name" => "Gravitas One",
	"slug" => "gravitas-one"
    ) , array(
	"fontFamily" => "Great Vibes",
	"name" => "Great Vibes",
	"slug" => "great-vibes"
    ) , array(
	"fontFamily" => "Grechen Fuemen",
	"name" => "Grechen Fuemen",
	"slug" => "grechen-fuemen"
    ) , array(
	"fontFamily" => "Grenze",
	"name" => "Grenze",
	"slug" => "grenze"
    ) , array(
	"fontFamily" => "Grenze Gotisch",
	"name" => "Grenze Gotisch",
	"slug" => "grenze-gotisch"
    ) , array(
	"fontFamily" => "Grey Qo",
	"name" => "Grey Qo",
	"slug" => "grey-qo"
    ) , array(
	"fontFamily" => "Griffy",
	"name" => "Griffy",
	"slug" => "griffy"
    ) , array(
	"fontFamily" => "Gruppo",
	"name" => "Gruppo",
	"slug" => "gruppo"
    ) , array(
	"fontFamily" => "Gudea",
	"name" => "Gudea",
	"slug" => "gudea"
    ) , array(
	"fontFamily" => "Gugi",
	"name" => "Gugi",
	"slug" => "gugi"
    ) , array(
	"fontFamily" => "Gupter",
	"name" => "Gupter",
	"slug" => "gupter"
    ) , array(
	"fontFamily" => "Gurajada",
	"name" => "Gurajada",
	"slug" => "gurajada"
    ) , array(
	"fontFamily" => "Gwendolyn",
	"name" => "Gwendolyn",
	"slug" => "gwendolyn"
    ) , array(
	"fontFamily" => "Habibi",
	"name" => "Habibi",
	"slug" => "habibi"
    ) , array(
	"fontFamily" => "Hachi Maru Pop",
	"name" => "Hachi Maru Pop",
	"slug" => "hachi-maru-pop"
    ) , array(
	"fontFamily" => "Hahmlet",
	"name" => "Hahmlet",
	"slug" => "hahmlet"
    ) , array(
	"fontFamily" => "Halant",
	"name" => "Halant",
	"slug" => "halant"
    ) , array(
	"fontFamily" => "Hammersmith One",
	"name" => "Hammersmith One",
	"slug" => "hammersmith-one"
    ) , array(
	"fontFamily" => "Hanalei",
	"name" => "Hanalei",
	"slug" => "hanalei"
    ) , array(
	"fontFamily" => "Hanalei Fill",
	"name" => "Hanalei Fill",
	"slug" => "hanalei-fill"
    ) , array(
	"fontFamily" => "Handlee",
	"name" => "Handlee",
	"slug" => "handlee"
    ) , array(
	"fontFamily" => "Hanuman",
	"name" => "Hanuman",
	"slug" => "hanuman"
    ) , array(
	"fontFamily" => "Happy Monkey",
	"name" => "Happy Monkey",
	"slug" => "happy-monkey"
    ) , array(
	"fontFamily" => "Harmattan",
	"name" => "Harmattan",
	"slug" => "harmattan"
    ) , array(
	"fontFamily" => "Headland One",
	"name" => "Headland One",
	"slug" => "headland-one"
    ) , array(
	"fontFamily" => "Heebo",
	"name" => "Heebo",
	"slug" => "heebo"
    ) , array(
	"fontFamily" => "Henny Penny",
	"name" => "Henny Penny",
	"slug" => "henny-penny"
    ) , array(
	"fontFamily" => "Hepta Slab",
	"name" => "Hepta Slab",
	"slug" => "hepta-slab"
    ) , array(
	"fontFamily" => "Herr Von Muellerhoff",
	"name" => "Herr Von Muellerhoff",
	"slug" => "herr-von-muellerhoff"
    ) , array(
	"fontFamily" => "Hi Melody",
	"name" => "Hi Melody",
	"slug" => "hi-melody"
    ) , array(
	"fontFamily" => "Hina Mincho",
	"name" => "Hina Mincho",
	"slug" => "hina-mincho"
    ) , array(
	"fontFamily" => "Hind",
	"name" => "Hind",
	"slug" => "hind"
    ) , array(
	"fontFamily" => "Hind Guntur",
	"name" => "Hind Guntur",
	"slug" => "hind-guntur"
    ) , array(
	"fontFamily" => "Hind Madurai",
	"name" => "Hind Madurai",
	"slug" => "hind-madurai"
    ) , array(
	"fontFamily" => "Hind Siliguri",
	"name" => "Hind Siliguri",
	"slug" => "hind-siliguri"
    ) , array(
	"fontFamily" => "Hind Vadodara",
	"name" => "Hind Vadodara",
	"slug" => "hind-vadodara"
    ) , array(
	"fontFamily" => "Holtwood One SC",
	"name" => "Holtwood One SC",
	"slug" => "holtwood-one-sc"
    ) , array(
	"fontFamily" => "Homemade Apple",
	"name" => "Homemade Apple",
	"slug" => "homemade-apple"
    ) , array(
	"fontFamily" => "Homenaje",
	"name" => "Homenaje",
	"slug" => "homenaje"
    ) , array(
	"fontFamily" => "Hurricane",
	"name" => "Hurricane",
	"slug" => "hurricane"
    ) , array(
	"fontFamily" => "IBM Plex Mono",
	"name" => "IBM Plex Mono",
	"slug" => "ibm-plex-mono"
    ) , array(
	"fontFamily" => "IBM Plex Sans",
	"name" => "IBM Plex Sans",
	"slug" => "ibm-plex-sans"
    ) , array(
	"fontFamily" => "IBM Plex Sans Arabic",
	"name" => "IBM Plex Sans Arabic",
	"slug" => "ibm-plex-sans-arabic"
    ) , array(
	"fontFamily" => "IBM Plex Sans Condensed",
	"name" => "IBM Plex Sans Condensed",
	"slug" => "ibm-plex-sans-condensed"
    ) , array(
	"fontFamily" => "IBM Plex Sans Devanagari",
	"name" => "IBM Plex Sans Devanagari",
	"slug" => "ibm-plex-sans-devanagari"
    ) , array(
	"fontFamily" => "IBM Plex Sans Hebrew",
	"name" => "IBM Plex Sans Hebrew",
	"slug" => "ibm-plex-sans-hebrew"
    ) , array(
	"fontFamily" => "IBM Plex Sans KR",
	"name" => "IBM Plex Sans KR",
	"slug" => "ibm-plex-sans-kr"
    ) , array(
	"fontFamily" => "IBM Plex Sans Thai",
	"name" => "IBM Plex Sans Thai",
	"slug" => "ibm-plex-sans-thai"
    ) , array(
	"fontFamily" => "IBM Plex Sans Thai Looped",
	"name" => "IBM Plex Sans Thai Looped",
	"slug" => "ibm-plex-sans-thai-looped"
    ) , array(
	"fontFamily" => "IBM Plex Serif",
	"name" => "IBM Plex Serif",
	"slug" => "ibm-plex-serif"
    ) , array(
	"fontFamily" => "IM Fell DW Pica",
	"name" => "IM Fell DW Pica",
	"slug" => "im-fell-dw-pica"
    ) , array(
	"fontFamily" => "IM Fell DW Pica SC",
	"name" => "IM Fell DW Pica SC",
	"slug" => "im-fell-dw-pica-sc"
    ) , array(
	"fontFamily" => "IM Fell Double Pica",
	"name" => "IM Fell Double Pica",
	"slug" => "im-fell-double-pica"
    ) , array(
	"fontFamily" => "IM Fell Double Pica SC",
	"name" => "IM Fell Double Pica SC",
	"slug" => "im-fell-double-pica-sc"
    ) , array(
	"fontFamily" => "IM Fell English",
	"name" => "IM Fell English",
	"slug" => "im-fell-english"
    ) , array(
	"fontFamily" => "IM Fell English SC",
	"name" => "IM Fell English SC",
	"slug" => "im-fell-english-sc"
    ) , array(
	"fontFamily" => "IM Fell French Canon",
	"name" => "IM Fell French Canon",
	"slug" => "im-fell-french-canon"
    ) , array(
	"fontFamily" => "IM Fell French Canon SC",
	"name" => "IM Fell French Canon SC",
	"slug" => "im-fell-french-canon-sc"
    ) , array(
	"fontFamily" => "IM Fell Great Primer",
	"name" => "IM Fell Great Primer",
	"slug" => "im-fell-great-primer"
    ) , array(
	"fontFamily" => "IM Fell Great Primer SC",
	"name" => "IM Fell Great Primer SC",
	"slug" => "im-fell-great-primer-sc"
    ) , array(
	"fontFamily" => "Ibarra Real Nova",
	"name" => "Ibarra Real Nova",
	"slug" => "ibarra-real-nova"
    ) , array(
	"fontFamily" => "Iceberg",
	"name" => "Iceberg",
	"slug" => "iceberg"
    ) , array(
	"fontFamily" => "Iceland",
	"name" => "Iceland",
	"slug" => "iceland"
    ) , array(
	"fontFamily" => "Imbue",
	"name" => "Imbue",
	"slug" => "imbue"
    ) , array(
	"fontFamily" => "Imperial Script",
	"name" => "Imperial Script",
	"slug" => "imperial-script"
    ) , array(
	"fontFamily" => "Imprima",
	"name" => "Imprima",
	"slug" => "imprima"
    ) , array(
	"fontFamily" => "Inconsolata",
	"name" => "Inconsolata",
	"slug" => "inconsolata"
    ) , array(
	"fontFamily" => "Inder",
	"name" => "Inder",
	"slug" => "inder"
    ) , array(
	"fontFamily" => "Indie Flower",
	"name" => "Indie Flower",
	"slug" => "indie-flower"
    ) , array(
	"fontFamily" => "Inika",
	"name" => "Inika",
	"slug" => "inika"
    ) , array(
	"fontFamily" => "Inknut Antiqua",
	"name" => "Inknut Antiqua",
	"slug" => "inknut-antiqua"
    ) , array(
	"fontFamily" => "Inria Sans",
	"name" => "Inria Sans",
	"slug" => "inria-sans"
    ) , array(
	"fontFamily" => "Inria Serif",
	"name" => "Inria Serif",
	"slug" => "inria-serif"
    ) , array(
	"fontFamily" => "Inspiration",
	"name" => "Inspiration",
	"slug" => "inspiration"
    ) , array(
	"fontFamily" => "Inter",
	"name" => "Inter",
	"slug" => "inter"
    ) , array(
	"fontFamily" => "Irish Grover",
	"name" => "Irish Grover",
	"slug" => "irish-grover"
    ) , array(
	"fontFamily" => "Island Moments",
	"name" => "Island Moments",
	"slug" => "island-moments"
    ) , array(
	"fontFamily" => "Istok Web",
	"name" => "Istok Web",
	"slug" => "istok-web"
    ) , array(
	"fontFamily" => "Italiana",
	"name" => "Italiana",
	"slug" => "italiana"
    ) , array(
	"fontFamily" => "Italianno",
	"name" => "Italianno",
	"slug" => "italianno"
    ) , array(
	"fontFamily" => "Itim",
	"name" => "Itim",
	"slug" => "itim"
    ) , array(
	"fontFamily" => "Jacques Francois",
	"name" => "Jacques Francois",
	"slug" => "jacques-francois"
    ) , array(
	"fontFamily" => "Jacques Francois Shadow",
	"name" => "Jacques Francois Shadow",
	"slug" => "jacques-francois-shadow"
    ) , array(
	"fontFamily" => "Jaldi",
	"name" => "Jaldi",
	"slug" => "jaldi"
    ) , array(
	"fontFamily" => "JetBrains Mono",
	"name" => "JetBrains Mono",
	"slug" => "jetbrains-mono"
    ) , array(
	"fontFamily" => "Jim Nightshade",
	"name" => "Jim Nightshade",
	"slug" => "jim-nightshade"
    ) , array(
	"fontFamily" => "Jockey One",
	"name" => "Jockey One",
	"slug" => "jockey-one"
    ) , array(
	"fontFamily" => "Jolly Lodger",
	"name" => "Jolly Lodger",
	"slug" => "jolly-lodger"
    ) , array(
	"fontFamily" => "Jomhuria",
	"name" => "Jomhuria",
	"slug" => "jomhuria"
    ) , array(
	"fontFamily" => "Jomolhari",
	"name" => "Jomolhari",
	"slug" => "jomolhari"
    ) , array(
	"fontFamily" => "Josefin Sans",
	"name" => "Josefin Sans",
	"slug" => "josefin-sans"
    ) , array(
	"fontFamily" => "Josefin Slab",
	"name" => "Josefin Slab",
	"slug" => "josefin-slab"
    ) , array(
	"fontFamily" => "Jost",
	"name" => "Jost",
	"slug" => "jost"
    ) , array(
	"fontFamily" => "Joti One",
	"name" => "Joti One",
	"slug" => "joti-one"
    ) , array(
	"fontFamily" => "Jua",
	"name" => "Jua",
	"slug" => "jua"
    ) , array(
	"fontFamily" => "Judson",
	"name" => "Judson",
	"slug" => "judson"
    ) , array(
	"fontFamily" => "Julee",
	"name" => "Julee",
	"slug" => "julee"
    ) , array(
	"fontFamily" => "Julius Sans One",
	"name" => "Julius Sans One",
	"slug" => "julius-sans-one"
    ) , array(
	"fontFamily" => "Junge",
	"name" => "Junge",
	"slug" => "junge"
    ) , array(
	"fontFamily" => "Jura",
	"name" => "Jura",
	"slug" => "jura"
    ) , array(
	"fontFamily" => "Just Another Hand",
	"name" => "Just Another Hand",
	"slug" => "just-another-hand"
    ) , array(
	"fontFamily" => "Just Me Again Down Here",
	"name" => "Just Me Again Down Here",
	"slug" => "just-me-again-down-here"
    ) , array(
	"fontFamily" => "K2D",
	"name" => "K2D",
	"slug" => "k2d"
    ) , array(
	"fontFamily" => "Kadwa",
	"name" => "Kadwa",
	"slug" => "kadwa"
    ) , array(
	"fontFamily" => "Kaisei Decol",
	"name" => "Kaisei Decol",
	"slug" => "kaisei-decol"
    ) , array(
	"fontFamily" => "Kaisei HarunoUmi",
	"name" => "Kaisei HarunoUmi",
	"slug" => "kaisei-harunoumi"
    ) , array(
	"fontFamily" => "Kaisei Opti",
	"name" => "Kaisei Opti",
	"slug" => "kaisei-opti"
    ) , array(
	"fontFamily" => "Kaisei Tokumin",
	"name" => "Kaisei Tokumin",
	"slug" => "kaisei-tokumin"
    ) , array(
	"fontFamily" => "Kalam",
	"name" => "Kalam",
	"slug" => "kalam"
    ) , array(
	"fontFamily" => "Kameron",
	"name" => "Kameron",
	"slug" => "kameron"
    ) , array(
	"fontFamily" => "Kanit",
	"name" => "Kanit",
	"slug" => "kanit"
    ) , array(
	"fontFamily" => "Kantumruy",
	"name" => "Kantumruy",
	"slug" => "kantumruy"
    ) , array(
	"fontFamily" => "Karantina",
	"name" => "Karantina",
	"slug" => "karantina"
    ) , array(
	"fontFamily" => "Karla",
	"name" => "Karla",
	"slug" => "karla"
    ) , array(
	"fontFamily" => "Karma",
	"name" => "Karma",
	"slug" => "karma"
    ) , array(
	"fontFamily" => "Katibeh",
	"name" => "Katibeh",
	"slug" => "katibeh"
    ) , array(
	"fontFamily" => "Kaushan Script",
	"name" => "Kaushan Script",
	"slug" => "kaushan-script"
    ) , array(
	"fontFamily" => "Kavivanar",
	"name" => "Kavivanar",
	"slug" => "kavivanar"
    ) , array(
	"fontFamily" => "Kavoon",
	"name" => "Kavoon",
	"slug" => "kavoon"
    ) , array(
	"fontFamily" => "Kdam Thmor",
	"name" => "Kdam Thmor",
	"slug" => "kdam-thmor"
    ) , array(
	"fontFamily" => "Keania One",
	"name" => "Keania One",
	"slug" => "keania-one"
    ) , array(
	"fontFamily" => "Kelly Slab",
	"name" => "Kelly Slab",
	"slug" => "kelly-slab"
    ) , array(
	"fontFamily" => "Kenia",
	"name" => "Kenia",
	"slug" => "kenia"
    ) , array(
	"fontFamily" => "Khand",
	"name" => "Khand",
	"slug" => "khand"
    ) , array(
	"fontFamily" => "Khmer",
	"name" => "Khmer",
	"slug" => "khmer"
    ) , array(
	"fontFamily" => "Khula",
	"name" => "Khula",
	"slug" => "khula"
    ) , array(
	"fontFamily" => "Kings",
	"name" => "Kings",
	"slug" => "kings"
    ) , array(
	"fontFamily" => "Kirang Haerang",
	"name" => "Kirang Haerang",
	"slug" => "kirang-haerang"
    ) , array(
	"fontFamily" => "Kite One",
	"name" => "Kite One",
	"slug" => "kite-one"
    ) , array(
	"fontFamily" => "Kiwi Maru",
	"name" => "Kiwi Maru",
	"slug" => "kiwi-maru"
    ) , array(
	"fontFamily" => "Klee One",
	"name" => "Klee One",
	"slug" => "klee-one"
    ) , array(
	"fontFamily" => "Knewave",
	"name" => "Knewave",
	"slug" => "knewave"
    ) , array(
	"fontFamily" => "KoHo",
	"name" => "KoHo",
	"slug" => "koho"
    ) , array(
	"fontFamily" => "Kodchasan",
	"name" => "Kodchasan",
	"slug" => "kodchasan"
    ) , array(
	"fontFamily" => "Koh Santepheap",
	"name" => "Koh Santepheap",
	"slug" => "koh-santepheap"
    ) , array(
	"fontFamily" => "Kolker Brush",
	"name" => "Kolker Brush",
	"slug" => "kolker-brush"
    ) , array(
	"fontFamily" => "Kosugi",
	"name" => "Kosugi",
	"slug" => "kosugi"
    ) , array(
	"fontFamily" => "Kosugi Maru",
	"name" => "Kosugi Maru",
	"slug" => "kosugi-maru"
    ) , array(
	"fontFamily" => "Kotta One",
	"name" => "Kotta One",
	"slug" => "kotta-one"
    ) , array(
	"fontFamily" => "Koulen",
	"name" => "Koulen",
	"slug" => "koulen"
    ) , array(
	"fontFamily" => "Kranky",
	"name" => "Kranky",
	"slug" => "kranky"
    ) , array(
	"fontFamily" => "Kreon",
	"name" => "Kreon",
	"slug" => "kreon"
    ) , array(
	"fontFamily" => "Kristi",
	"name" => "Kristi",
	"slug" => "kristi"
    ) , array(
	"fontFamily" => "Krona One",
	"name" => "Krona One",
	"slug" => "krona-one"
    ) , array(
	"fontFamily" => "Krub",
	"name" => "Krub",
	"slug" => "krub"
    ) , array(
	"fontFamily" => "Kufam",
	"name" => "Kufam",
	"slug" => "kufam"
    ) , array(
	"fontFamily" => "Kulim Park",
	"name" => "Kulim Park",
	"slug" => "kulim-park"
    ) , array(
	"fontFamily" => "Kumar One",
	"name" => "Kumar One",
	"slug" => "kumar-one"
    ) , array(
	"fontFamily" => "Kumar One Outline",
	"name" => "Kumar One Outline",
	"slug" => "kumar-one-outline"
    ) , array(
	"fontFamily" => "Kumbh Sans",
	"name" => "Kumbh Sans",
	"slug" => "kumbh-sans"
    ) , array(
	"fontFamily" => "Kurale",
	"name" => "Kurale",
	"slug" => "kurale"
    ) , array(
	"fontFamily" => "La Belle Aurore",
	"name" => "La Belle Aurore",
	"slug" => "la-belle-aurore"
    ) , array(
	"fontFamily" => "Lacquer",
	"name" => "Lacquer",
	"slug" => "lacquer"
    ) , array(
	"fontFamily" => "Laila",
	"name" => "Laila",
	"slug" => "laila"
    ) , array(
	"fontFamily" => "Lakki Reddy",
	"name" => "Lakki Reddy",
	"slug" => "lakki-reddy"
    ) , array(
	"fontFamily" => "Lalezar",
	"name" => "Lalezar",
	"slug" => "lalezar"
    ) , array(
	"fontFamily" => "Lancelot",
	"name" => "Lancelot",
	"slug" => "lancelot"
    ) , array(
	"fontFamily" => "Langar",
	"name" => "Langar",
	"slug" => "langar"
    ) , array(
	"fontFamily" => "Lateef",
	"name" => "Lateef",
	"slug" => "lateef"
    ) , array(
	"fontFamily" => "Lato",
	"name" => "Lato",
	"slug" => "lato"
    ) , array(
	"fontFamily" => "League Script",
	"name" => "League Script",
	"slug" => "league-script"
    ) , array(
	"fontFamily" => "Leckerli One",
	"name" => "Leckerli One",
	"slug" => "leckerli-one"
    ) , array(
	"fontFamily" => "Ledger",
	"name" => "Ledger",
	"slug" => "ledger"
    ) , array(
	"fontFamily" => "Lekton",
	"name" => "Lekton",
	"slug" => "lekton"
    ) , array(
	"fontFamily" => "Lemon",
	"name" => "Lemon",
	"slug" => "lemon"
    ) , array(
	"fontFamily" => "Lemonada",
	"name" => "Lemonada",
	"slug" => "lemonada"
    ) , array(
	"fontFamily" => "Lexend",
	"name" => "Lexend",
	"slug" => "lexend"
    ) , array(
	"fontFamily" => "Lexend Deca",
	"name" => "Lexend Deca",
	"slug" => "lexend-deca"
    ) , array(
	"fontFamily" => "Lexend Exa",
	"name" => "Lexend Exa",
	"slug" => "lexend-exa"
    ) , array(
	"fontFamily" => "Lexend Giga",
	"name" => "Lexend Giga",
	"slug" => "lexend-giga"
    ) , array(
	"fontFamily" => "Lexend Mega",
	"name" => "Lexend Mega",
	"slug" => "lexend-mega"
    ) , array(
	"fontFamily" => "Lexend Peta",
	"name" => "Lexend Peta",
	"slug" => "lexend-peta"
    ) , array(
	"fontFamily" => "Lexend Tera",
	"name" => "Lexend Tera",
	"slug" => "lexend-tera"
    ) , array(
	"fontFamily" => "Lexend Zetta",
	"name" => "Lexend Zetta",
	"slug" => "lexend-zetta"
    ) , array(
	"fontFamily" => "Libre Barcode 128",
	"name" => "Libre Barcode 128",
	"slug" => "libre-barcode-128"
    ) , array(
	"fontFamily" => "Libre Barcode 128 Text",
	"name" => "Libre Barcode 128 Text",
	"slug" => "libre-barcode-128-text"
    ) , array(
	"fontFamily" => "Libre Barcode 39",
	"name" => "Libre Barcode 39",
	"slug" => "libre-barcode-39"
    ) , array(
	"fontFamily" => "Libre Barcode 39 Extended",
	"name" => "Libre Barcode 39 Extended",
	"slug" => "libre-barcode-39-extended"
    ) , array(
	"fontFamily" => "Libre Barcode 39 Extended Text",
	"name" => "Libre Barcode 39 Extended Text",
	"slug" => "libre-barcode-39-extended-text"
    ) , array(
	"fontFamily" => "Libre Barcode 39 Text",
	"name" => "Libre Barcode 39 Text",
	"slug" => "libre-barcode-39-text"
    ) , array(
	"fontFamily" => "Libre Barcode EAN13 Text",
	"name" => "Libre Barcode EAN13 Text",
	"slug" => "libre-barcode-ean13-text"
    ) , array(
	"fontFamily" => "Libre Baskerville",
	"name" => "Libre Baskerville",
	"slug" => "libre-baskerville"
    ) , array(
	"fontFamily" => "Libre Caslon Display",
	"name" => "Libre Caslon Display",
	"slug" => "libre-caslon-display"
    ) , array(
	"fontFamily" => "Libre Caslon Text",
	"name" => "Libre Caslon Text",
	"slug" => "libre-caslon-text"
    ) , array(
	"fontFamily" => "Libre Franklin",
	"name" => "Libre Franklin",
	"slug" => "libre-franklin"
    ) , array(
	"fontFamily" => "Licorice",
	"name" => "Licorice",
	"slug" => "licorice"
    ) , array(
	"fontFamily" => "Life Savers",
	"name" => "Life Savers",
	"slug" => "life-savers"
    ) , array(
	"fontFamily" => "Lilita One",
	"name" => "Lilita One",
	"slug" => "lilita-one"
    ) , array(
	"fontFamily" => "Lily Script One",
	"name" => "Lily Script One",
	"slug" => "lily-script-one"
    ) , array(
	"fontFamily" => "Limelight",
	"name" => "Limelight",
	"slug" => "limelight"
    ) , array(
	"fontFamily" => "Linden Hill",
	"name" => "Linden Hill",
	"slug" => "linden-hill"
    ) , array(
	"fontFamily" => "Literata",
	"name" => "Literata",
	"slug" => "literata"
    ) , array(
	"fontFamily" => "Liu Jian Mao Cao",
	"name" => "Liu Jian Mao Cao",
	"slug" => "liu-jian-mao-cao"
    ) , array(
	"fontFamily" => "Livvic",
	"name" => "Livvic",
	"slug" => "livvic"
    ) , array(
	"fontFamily" => "Lobster",
	"name" => "Lobster",
	"slug" => "lobster"
    ) , array(
	"fontFamily" => "Lobster Two",
	"name" => "Lobster Two",
	"slug" => "lobster-two"
    ) , array(
	"fontFamily" => "Londrina Outline",
	"name" => "Londrina Outline",
	"slug" => "londrina-outline"
    ) , array(
	"fontFamily" => "Londrina Shadow",
	"name" => "Londrina Shadow",
	"slug" => "londrina-shadow"
    ) , array(
	"fontFamily" => "Londrina Sketch",
	"name" => "Londrina Sketch",
	"slug" => "londrina-sketch"
    ) , array(
	"fontFamily" => "Londrina Solid",
	"name" => "Londrina Solid",
	"slug" => "londrina-solid"
    ) , array(
	"fontFamily" => "Long Cang",
	"name" => "Long Cang",
	"slug" => "long-cang"
    ) , array(
	"fontFamily" => "Lora",
	"name" => "Lora",
	"slug" => "lora"
    ) , array(
	"fontFamily" => "Love Light",
	"name" => "Love Light",
	"slug" => "love-light"
    ) , array(
	"fontFamily" => "Love Ya Like A Sister",
	"name" => "Love Ya Like A Sister",
	"slug" => "love-ya-like-a-sister"
    ) , array(
	"fontFamily" => "Loved by the King",
	"name" => "Loved by the King",
	"slug" => "loved-by-the-king"
    ) , array(
	"fontFamily" => "Lovers Quarrel",
	"name" => "Lovers Quarrel",
	"slug" => "lovers-quarrel"
    ) , array(
	"fontFamily" => "Luckiest Guy",
	"name" => "Luckiest Guy",
	"slug" => "luckiest-guy"
    ) , array(
	"fontFamily" => "Lusitana",
	"name" => "Lusitana",
	"slug" => "lusitana"
    ) , array(
	"fontFamily" => "Lustria",
	"name" => "Lustria",
	"slug" => "lustria"
    ) , array(
	"fontFamily" => "Luxurious Roman",
	"name" => "Luxurious Roman",
	"slug" => "luxurious-roman"
    ) , array(
	"fontFamily" => "Luxurious Script",
	"name" => "Luxurious Script",
	"slug" => "luxurious-script"
    ) , array(
	"fontFamily" => "M PLUS 1",
	"name" => "M PLUS 1",
	"slug" => "m-plus-1"
    ) , array(
	"fontFamily" => "M PLUS 1 Code",
	"name" => "M PLUS 1 Code",
	"slug" => "m-plus-1-code"
    ) , array(
	"fontFamily" => "M PLUS 1p",
	"name" => "M PLUS 1p",
	"slug" => "m-plus-1p"
    ) , array(
	"fontFamily" => "M PLUS 2",
	"name" => "M PLUS 2",
	"slug" => "m-plus-2"
    ) , array(
	"fontFamily" => "M PLUS Code Latin",
	"name" => "M PLUS Code Latin",
	"slug" => "m-plus-code-latin"
    ) , array(
	"fontFamily" => "M PLUS Rounded 1c",
	"name" => "M PLUS Rounded 1c",
	"slug" => "m-plus-rounded-1c"
    ) , array(
	"fontFamily" => "Ma Shan Zheng",
	"name" => "Ma Shan Zheng",
	"slug" => "ma-shan-zheng"
    ) , array(
	"fontFamily" => "Macondo",
	"name" => "Macondo",
	"slug" => "macondo"
    ) , array(
	"fontFamily" => "Macondo Swash Caps",
	"name" => "Macondo Swash Caps",
	"slug" => "macondo-swash-caps"
    ) , array(
	"fontFamily" => "Mada",
	"name" => "Mada",
	"slug" => "mada"
    ) , array(
	"fontFamily" => "Magra",
	"name" => "Magra",
	"slug" => "magra"
    ) , array(
	"fontFamily" => "Maiden Orange",
	"name" => "Maiden Orange",
	"slug" => "maiden-orange"
    ) , array(
	"fontFamily" => "Maitree",
	"name" => "Maitree",
	"slug" => "maitree"
    ) , array(
	"fontFamily" => "Major Mono Display",
	"name" => "Major Mono Display",
	"slug" => "major-mono-display"
    ) , array(
	"fontFamily" => "Mako",
	"name" => "Mako",
	"slug" => "mako"
    ) , array(
	"fontFamily" => "Mali",
	"name" => "Mali",
	"slug" => "mali"
    ) , array(
	"fontFamily" => "Mallanna",
	"name" => "Mallanna",
	"slug" => "mallanna"
    ) , array(
	"fontFamily" => "Mandali",
	"name" => "Mandali",
	"slug" => "mandali"
    ) , array(
	"fontFamily" => "Manjari",
	"name" => "Manjari",
	"slug" => "manjari"
    ) , array(
	"fontFamily" => "Manrope",
	"name" => "Manrope",
	"slug" => "manrope"
    ) , array(
	"fontFamily" => "Mansalva",
	"name" => "Mansalva",
	"slug" => "mansalva"
    ) , array(
	"fontFamily" => "Manuale",
	"name" => "Manuale",
	"slug" => "manuale"
    ) , array(
	"fontFamily" => "Marcellus",
	"name" => "Marcellus",
	"slug" => "marcellus"
    ) , array(
	"fontFamily" => "Marcellus SC",
	"name" => "Marcellus SC",
	"slug" => "marcellus-sc"
    ) , array(
	"fontFamily" => "Marck Script",
	"name" => "Marck Script",
	"slug" => "marck-script"
    ) , array(
	"fontFamily" => "Margarine",
	"name" => "Margarine",
	"slug" => "margarine"
    ) , array(
	"fontFamily" => "Markazi Text",
	"name" => "Markazi Text",
	"slug" => "markazi-text"
    ) , array(
	"fontFamily" => "Marko One",
	"name" => "Marko One",
	"slug" => "marko-one"
    ) , array(
	"fontFamily" => "Marmelad",
	"name" => "Marmelad",
	"slug" => "marmelad"
    ) , array(
	"fontFamily" => "Martel",
	"name" => "Martel",
	"slug" => "martel"
    ) , array(
	"fontFamily" => "Martel Sans",
	"name" => "Martel Sans",
	"slug" => "martel-sans"
    ) , array(
	"fontFamily" => "Marvel",
	"name" => "Marvel",
	"slug" => "marvel"
    ) , array(
	"fontFamily" => "Mate",
	"name" => "Mate",
	"slug" => "mate"
    ) , array(
	"fontFamily" => "Mate SC",
	"name" => "Mate SC",
	"slug" => "mate-sc"
    ) , array(
	"fontFamily" => "Maven Pro",
	"name" => "Maven Pro",
	"slug" => "maven-pro"
    ) , array(
	"fontFamily" => "McLaren",
	"name" => "McLaren",
	"slug" => "mclaren"
    ) , array(
	"fontFamily" => "Mea Culpa",
	"name" => "Mea Culpa",
	"slug" => "mea-culpa"
    ) , array(
	"fontFamily" => "Meddon",
	"name" => "Meddon",
	"slug" => "meddon"
    ) , array(
	"fontFamily" => "MedievalSharp",
	"name" => "MedievalSharp",
	"slug" => "medievalsharp"
    ) , array(
	"fontFamily" => "Medula One",
	"name" => "Medula One",
	"slug" => "medula-one"
    ) , array(
	"fontFamily" => "Meera Inimai",
	"name" => "Meera Inimai",
	"slug" => "meera-inimai"
    ) , array(
	"fontFamily" => "Megrim",
	"name" => "Megrim",
	"slug" => "megrim"
    ) , array(
	"fontFamily" => "Meie Script",
	"name" => "Meie Script",
	"slug" => "meie-script"
    ) , array(
	"fontFamily" => "Meow Script",
	"name" => "Meow Script",
	"slug" => "meow-script"
    ) , array(
	"fontFamily" => "Merienda",
	"name" => "Merienda",
	"slug" => "merienda"
    ) , array(
	"fontFamily" => "Merienda One",
	"name" => "Merienda One",
	"slug" => "merienda-one"
    ) , array(
	"fontFamily" => "Merriweather",
	"name" => "Merriweather",
	"slug" => "merriweather"
    ) , array(
	"fontFamily" => "Merriweather Sans",
	"name" => "Merriweather Sans",
	"slug" => "merriweather-sans"
    ) , array(
	"fontFamily" => "Metal",
	"name" => "Metal",
	"slug" => "metal"
    ) , array(
	"fontFamily" => "Metal Mania",
	"name" => "Metal Mania",
	"slug" => "metal-mania"
    ) , array(
	"fontFamily" => "Metamorphous",
	"name" => "Metamorphous",
	"slug" => "metamorphous"
    ) , array(
	"fontFamily" => "Metrophobic",
	"name" => "Metrophobic",
	"slug" => "metrophobic"
    ) , array(
	"fontFamily" => "Michroma",
	"name" => "Michroma",
	"slug" => "michroma"
    ) , array(
	"fontFamily" => "Milonga",
	"name" => "Milonga",
	"slug" => "milonga"
    ) , array(
	"fontFamily" => "Miltonian",
	"name" => "Miltonian",
	"slug" => "miltonian"
    ) , array(
	"fontFamily" => "Miltonian Tattoo",
	"name" => "Miltonian Tattoo",
	"slug" => "miltonian-tattoo"
    ) , array(
	"fontFamily" => "Mina",
	"name" => "Mina",
	"slug" => "mina"
    ) , array(
	"fontFamily" => "Miniver",
	"name" => "Miniver",
	"slug" => "miniver"
    ) , array(
	"fontFamily" => "Miriam Libre",
	"name" => "Miriam Libre",
	"slug" => "miriam-libre"
    ) , array(
	"fontFamily" => "Mirza",
	"name" => "Mirza",
	"slug" => "mirza"
    ) , array(
	"fontFamily" => "Miss Fajardose",
	"name" => "Miss Fajardose",
	"slug" => "miss-fajardose"
    ) , array(
	"fontFamily" => "Mitr",
	"name" => "Mitr",
	"slug" => "mitr"
    ) , array(
	"fontFamily" => "Mochiy Pop One",
	"name" => "Mochiy Pop One",
	"slug" => "mochiy-pop-one"
    ) , array(
	"fontFamily" => "Mochiy Pop P One",
	"name" => "Mochiy Pop P One",
	"slug" => "mochiy-pop-p-one"
    ) , array(
	"fontFamily" => "Modak",
	"name" => "Modak",
	"slug" => "modak"
    ) , array(
	"fontFamily" => "Modern Antiqua",
	"name" => "Modern Antiqua",
	"slug" => "modern-antiqua"
    ) , array(
	"fontFamily" => "Mogra",
	"name" => "Mogra",
	"slug" => "mogra"
    ) , array(
	"fontFamily" => "Mohave",
	"name" => "Mohave",
	"slug" => "mohave"
    ) , array(
	"fontFamily" => "Molengo",
	"name" => "Molengo",
	"slug" => "molengo"
    ) , array(
	"fontFamily" => "Molle",
	"name" => "Molle",
	"slug" => "molle"
    ) , array(
	"fontFamily" => "Monda",
	"name" => "Monda",
	"slug" => "monda"
    ) , array(
	"fontFamily" => "Monofett",
	"name" => "Monofett",
	"slug" => "monofett"
    ) , array(
	"fontFamily" => "Monoton",
	"name" => "Monoton",
	"slug" => "monoton"
    ) , array(
	"fontFamily" => "Monsieur La Doulaise",
	"name" => "Monsieur La Doulaise",
	"slug" => "monsieur-la-doulaise"
    ) , array(
	"fontFamily" => "Montaga",
	"name" => "Montaga",
	"slug" => "montaga"
    ) , array(
	"fontFamily" => "Montagu Slab",
	"name" => "Montagu Slab",
	"slug" => "montagu-slab"
    ) , array(
	"fontFamily" => "MonteCarlo",
	"name" => "MonteCarlo",
	"slug" => "montecarlo"
    ) , array(
	"fontFamily" => "Montez",
	"name" => "Montez",
	"slug" => "montez"
    ) , array(
	"fontFamily" => "Montserrat",
	"name" => "Montserrat",
	"slug" => "montserrat"
    ) , array(
	"fontFamily" => "Montserrat Alternates",
	"name" => "Montserrat Alternates",
	"slug" => "montserrat-alternates"
    ) , array(
	"fontFamily" => "Montserrat Subrayada",
	"name" => "Montserrat Subrayada",
	"slug" => "montserrat-subrayada"
    ) , array(
	"fontFamily" => "Moo Lah Lah",
	"name" => "Moo Lah Lah",
	"slug" => "moo-lah-lah"
    ) , array(
	"fontFamily" => "Moon Dance",
	"name" => "Moon Dance",
	"slug" => "moon-dance"
    ) , array(
	"fontFamily" => "Moul",
	"name" => "Moul",
	"slug" => "moul"
    ) , array(
	"fontFamily" => "Moulpali",
	"name" => "Moulpali",
	"slug" => "moulpali"
    ) , array(
	"fontFamily" => "Mountains of Christmas",
	"name" => "Mountains of Christmas",
	"slug" => "mountains-of-christmas"
    ) , array(
	"fontFamily" => "Mouse Memoirs",
	"name" => "Mouse Memoirs",
	"slug" => "mouse-memoirs"
    ) , array(
	"fontFamily" => "Mr Bedfort",
	"name" => "Mr Bedfort",
	"slug" => "mr-bedfort"
    ) , array(
	"fontFamily" => "Mr Dafoe",
	"name" => "Mr Dafoe",
	"slug" => "mr-dafoe"
    ) , array(
	"fontFamily" => "Mr De Haviland",
	"name" => "Mr De Haviland",
	"slug" => "mr-de-haviland"
    ) , array(
	"fontFamily" => "Mrs Saint Delafield",
	"name" => "Mrs Saint Delafield",
	"slug" => "mrs-saint-delafield"
    ) , array(
	"fontFamily" => "Mrs Sheppards",
	"name" => "Mrs Sheppards",
	"slug" => "mrs-sheppards"
    ) , array(
	"fontFamily" => "Mukta",
	"name" => "Mukta",
	"slug" => "mukta"
    ) , array(
	"fontFamily" => "Mukta Mahee",
	"name" => "Mukta Mahee",
	"slug" => "mukta-mahee"
    ) , array(
	"fontFamily" => "Mukta Malar",
	"name" => "Mukta Malar",
	"slug" => "mukta-malar"
    ) , array(
	"fontFamily" => "Mukta Vaani",
	"name" => "Mukta Vaani",
	"slug" => "mukta-vaani"
    ) , array(
	"fontFamily" => "Mulish",
	"name" => "Mulish",
	"slug" => "mulish"
    ) , array(
	"fontFamily" => "Murecho",
	"name" => "Murecho",
	"slug" => "murecho"
    ) , array(
	"fontFamily" => "MuseoModerno",
	"name" => "MuseoModerno",
	"slug" => "museomoderno"
    ) , array(
	"fontFamily" => "Mystery Quest",
	"name" => "Mystery Quest",
	"slug" => "mystery-quest"
    ) , array(
	"fontFamily" => "NTR",
	"name" => "NTR",
	"slug" => "ntr"
    ) , array(
	"fontFamily" => "Nanum Brush Script",
	"name" => "Nanum Brush Script",
	"slug" => "nanum-brush-script"
    ) , array(
	"fontFamily" => "Nanum Gothic",
	"name" => "Nanum Gothic",
	"slug" => "nanum-gothic"
    ) , array(
	"fontFamily" => "Nanum Gothic Coding",
	"name" => "Nanum Gothic Coding",
	"slug" => "nanum-gothic-coding"
    ) , array(
	"fontFamily" => "Nanum Myeongjo",
	"name" => "Nanum Myeongjo",
	"slug" => "nanum-myeongjo"
    ) , array(
	"fontFamily" => "Nanum Pen Script",
	"name" => "Nanum Pen Script",
	"slug" => "nanum-pen-script"
    ) , array(
	"fontFamily" => "Neonderthaw",
	"name" => "Neonderthaw",
	"slug" => "neonderthaw"
    ) , array(
	"fontFamily" => "Nerko One",
	"name" => "Nerko One",
	"slug" => "nerko-one"
    ) , array(
	"fontFamily" => "Neucha",
	"name" => "Neucha",
	"slug" => "neucha"
    ) , array(
	"fontFamily" => "Neuton",
	"name" => "Neuton",
	"slug" => "neuton"
    ) , array(
	"fontFamily" => "New Rocker",
	"name" => "New Rocker",
	"slug" => "new-rocker"
    ) , array(
	"fontFamily" => "New Tegomin",
	"name" => "New Tegomin",
	"slug" => "new-tegomin"
    ) , array(
	"fontFamily" => "News Cycle",
	"name" => "News Cycle",
	"slug" => "news-cycle"
    ) , array(
	"fontFamily" => "Newsreader",
	"name" => "Newsreader",
	"slug" => "newsreader"
    ) , array(
	"fontFamily" => "Niconne",
	"name" => "Niconne",
	"slug" => "niconne"
    ) , array(
	"fontFamily" => "Niramit",
	"name" => "Niramit",
	"slug" => "niramit"
    ) , array(
	"fontFamily" => "Nixie One",
	"name" => "Nixie One",
	"slug" => "nixie-one"
    ) , array(
	"fontFamily" => "Nobile",
	"name" => "Nobile",
	"slug" => "nobile"
    ) , array(
	"fontFamily" => "Nokora",
	"name" => "Nokora",
	"slug" => "nokora"
    ) , array(
	"fontFamily" => "Norican",
	"name" => "Norican",
	"slug" => "norican"
    ) , array(
	"fontFamily" => "Nosifer",
	"name" => "Nosifer",
	"slug" => "nosifer"
    ) , array(
	"fontFamily" => "Notable",
	"name" => "Notable",
	"slug" => "notable"
    ) , array(
	"fontFamily" => "Nothing You Could Do",
	"name" => "Nothing You Could Do",
	"slug" => "nothing-you-could-do"
    ) , array(
	"fontFamily" => "Noticia Text",
	"name" => "Noticia Text",
	"slug" => "noticia-text"
    ) , array(
	"fontFamily" => "Noto Music",
	"name" => "Noto Music",
	"slug" => "noto-music"
    ) , array(
	"fontFamily" => "Noto Nastaliq Urdu",
	"name" => "Noto Nastaliq Urdu",
	"slug" => "noto-nastaliq-urdu"
    ) , array(
	"fontFamily" => "Noto Rashi Hebrew",
	"name" => "Noto Rashi Hebrew",
	"slug" => "noto-rashi-hebrew"
    ) , array(
	"fontFamily" => "Noto Sans",
	"name" => "Noto Sans",
	"slug" => "noto-sans"
    ) , array(
	"fontFamily" => "Noto Sans Adlam",
	"name" => "Noto Sans Adlam",
	"slug" => "noto-sans-adlam"
    ) , array(
	"fontFamily" => "Noto Sans Adlam Unjoined",
	"name" => "Noto Sans Adlam Unjoined",
	"slug" => "noto-sans-adlam-unjoined"
    ) , array(
	"fontFamily" => "Noto Sans Anatolian Hieroglyphs",
	"name" => "Noto Sans Anatolian Hieroglyphs",
	"slug" => "noto-sans-anatolian-hieroglyphs"
    ) , array(
	"fontFamily" => "Noto Sans Arabic",
	"name" => "Noto Sans Arabic",
	"slug" => "noto-sans-arabic"
    ) , array(
	"fontFamily" => "Noto Sans Armenian",
	"name" => "Noto Sans Armenian",
	"slug" => "noto-sans-armenian"
    ) , array(
	"fontFamily" => "Noto Sans Avestan",
	"name" => "Noto Sans Avestan",
	"slug" => "noto-sans-avestan"
    ) , array(
	"fontFamily" => "Noto Sans Balinese",
	"name" => "Noto Sans Balinese",
	"slug" => "noto-sans-balinese"
    ) , array(
	"fontFamily" => "Noto Sans Bamum",
	"name" => "Noto Sans Bamum",
	"slug" => "noto-sans-bamum"
    ) , array(
	"fontFamily" => "Noto Sans Bassa Vah",
	"name" => "Noto Sans Bassa Vah",
	"slug" => "noto-sans-bassa-vah"
    ) , array(
	"fontFamily" => "Noto Sans Batak",
	"name" => "Noto Sans Batak",
	"slug" => "noto-sans-batak"
    ) , array(
	"fontFamily" => "Noto Sans Bengali",
	"name" => "Noto Sans Bengali",
	"slug" => "noto-sans-bengali"
    ) , array(
	"fontFamily" => "Noto Sans Bhaiksuki",
	"name" => "Noto Sans Bhaiksuki",
	"slug" => "noto-sans-bhaiksuki"
    ) , array(
	"fontFamily" => "Noto Sans Brahmi",
	"name" => "Noto Sans Brahmi",
	"slug" => "noto-sans-brahmi"
    ) , array(
	"fontFamily" => "Noto Sans Buginese",
	"name" => "Noto Sans Buginese",
	"slug" => "noto-sans-buginese"
    ) , array(
	"fontFamily" => "Noto Sans Buhid",
	"name" => "Noto Sans Buhid",
	"slug" => "noto-sans-buhid"
    ) , array(
	"fontFamily" => "Noto Sans Canadian Aboriginal",
	"name" => "Noto Sans Canadian Aboriginal",
	"slug" => "noto-sans-canadian-aboriginal"
    ) , array(
	"fontFamily" => "Noto Sans Carian",
	"name" => "Noto Sans Carian",
	"slug" => "noto-sans-carian"
    ) , array(
	"fontFamily" => "Noto Sans Caucasian Albanian",
	"name" => "Noto Sans Caucasian Albanian",
	"slug" => "noto-sans-caucasian-albanian"
    ) , array(
	"fontFamily" => "Noto Sans Chakma",
	"name" => "Noto Sans Chakma",
	"slug" => "noto-sans-chakma"
    ) , array(
	"fontFamily" => "Noto Sans Cham",
	"name" => "Noto Sans Cham",
	"slug" => "noto-sans-cham"
    ) , array(
	"fontFamily" => "Noto Sans Cherokee",
	"name" => "Noto Sans Cherokee",
	"slug" => "noto-sans-cherokee"
    ) , array(
	"fontFamily" => "Noto Sans Coptic",
	"name" => "Noto Sans Coptic",
	"slug" => "noto-sans-coptic"
    ) , array(
	"fontFamily" => "Noto Sans Cuneiform",
	"name" => "Noto Sans Cuneiform",
	"slug" => "noto-sans-cuneiform"
    ) , array(
	"fontFamily" => "Noto Sans Cypriot",
	"name" => "Noto Sans Cypriot",
	"slug" => "noto-sans-cypriot"
    ) , array(
	"fontFamily" => "Noto Sans Deseret",
	"name" => "Noto Sans Deseret",
	"slug" => "noto-sans-deseret"
    ) , array(
	"fontFamily" => "Noto Sans Devanagari",
	"name" => "Noto Sans Devanagari",
	"slug" => "noto-sans-devanagari"
    ) , array(
	"fontFamily" => "Noto Sans Display",
	"name" => "Noto Sans Display",
	"slug" => "noto-sans-display"
    ) , array(
	"fontFamily" => "Noto Sans Duployan",
	"name" => "Noto Sans Duployan",
	"slug" => "noto-sans-duployan"
    ) , array(
	"fontFamily" => "Noto Sans Egyptian Hieroglyphs",
	"name" => "Noto Sans Egyptian Hieroglyphs",
	"slug" => "noto-sans-egyptian-hieroglyphs"
    ) , array(
	"fontFamily" => "Noto Sans Elbasan",
	"name" => "Noto Sans Elbasan",
	"slug" => "noto-sans-elbasan"
    ) , array(
	"fontFamily" => "Noto Sans Elymaic",
	"name" => "Noto Sans Elymaic",
	"slug" => "noto-sans-elymaic"
    ) , array(
	"fontFamily" => "Noto Sans Georgian",
	"name" => "Noto Sans Georgian",
	"slug" => "noto-sans-georgian"
    ) , array(
	"fontFamily" => "Noto Sans Glagolitic",
	"name" => "Noto Sans Glagolitic",
	"slug" => "noto-sans-glagolitic"
    ) , array(
	"fontFamily" => "Noto Sans Gothic",
	"name" => "Noto Sans Gothic",
	"slug" => "noto-sans-gothic"
    ) , array(
	"fontFamily" => "Noto Sans Grantha",
	"name" => "Noto Sans Grantha",
	"slug" => "noto-sans-grantha"
    ) , array(
	"fontFamily" => "Noto Sans Gujarati",
	"name" => "Noto Sans Gujarati",
	"slug" => "noto-sans-gujarati"
    ) , array(
	"fontFamily" => "Noto Sans Gunjala Gondi",
	"name" => "Noto Sans Gunjala Gondi",
	"slug" => "noto-sans-gunjala-gondi"
    ) , array(
	"fontFamily" => "Noto Sans Gurmukhi",
	"name" => "Noto Sans Gurmukhi",
	"slug" => "noto-sans-gurmukhi"
    ) , array(
	"fontFamily" => "Noto Sans HK",
	"name" => "Noto Sans HK",
	"slug" => "noto-sans-hk"
    ) , array(
	"fontFamily" => "Noto Sans Hanifi Rohingya",
	"name" => "Noto Sans Hanifi Rohingya",
	"slug" => "noto-sans-hanifi-rohingya"
    ) , array(
	"fontFamily" => "Noto Sans Hanunoo",
	"name" => "Noto Sans Hanunoo",
	"slug" => "noto-sans-hanunoo"
    ) , array(
	"fontFamily" => "Noto Sans Hatran",
	"name" => "Noto Sans Hatran",
	"slug" => "noto-sans-hatran"
    ) , array(
	"fontFamily" => "Noto Sans Imperial Aramaic",
	"name" => "Noto Sans Imperial Aramaic",
	"slug" => "noto-sans-imperial-aramaic"
    ) , array(
	"fontFamily" => "Noto Sans Indic Siyaq Numbers",
	"name" => "Noto Sans Indic Siyaq Numbers",
	"slug" => "noto-sans-indic-siyaq-numbers"
    ) , array(
	"fontFamily" => "Noto Sans Inscriptional Pahlavi",
	"name" => "Noto Sans Inscriptional Pahlavi",
	"slug" => "noto-sans-inscriptional-pahlavi"
    ) , array(
	"fontFamily" => "Noto Sans Inscriptional Parthian",
	"name" => "Noto Sans Inscriptional Parthian",
	"slug" => "noto-sans-inscriptional-parthian"
    ) , array(
	"fontFamily" => "Noto Sans JP",
	"name" => "Noto Sans JP",
	"slug" => "noto-sans-jp"
    ) , array(
	"fontFamily" => "Noto Sans Javanese",
	"name" => "Noto Sans Javanese",
	"slug" => "noto-sans-javanese"
    ) , array(
	"fontFamily" => "Noto Sans KR",
	"name" => "Noto Sans KR",
	"slug" => "noto-sans-kr"
    ) , array(
	"fontFamily" => "Noto Sans Kaithi",
	"name" => "Noto Sans Kaithi",
	"slug" => "noto-sans-kaithi"
    ) , array(
	"fontFamily" => "Noto Sans Kannada",
	"name" => "Noto Sans Kannada",
	"slug" => "noto-sans-kannada"
    ) , array(
	"fontFamily" => "Noto Sans Kayah Li",
	"name" => "Noto Sans Kayah Li",
	"slug" => "noto-sans-kayah-li"
    ) , array(
	"fontFamily" => "Noto Sans Kharoshthi",
	"name" => "Noto Sans Kharoshthi",
	"slug" => "noto-sans-kharoshthi"
    ) , array(
	"fontFamily" => "Noto Sans Khmer",
	"name" => "Noto Sans Khmer",
	"slug" => "noto-sans-khmer"
    ) , array(
	"fontFamily" => "Noto Sans Khojki",
	"name" => "Noto Sans Khojki",
	"slug" => "noto-sans-khojki"
    ) , array(
	"fontFamily" => "Noto Sans Khudawadi",
	"name" => "Noto Sans Khudawadi",
	"slug" => "noto-sans-khudawadi"
    ) , array(
	"fontFamily" => "Noto Sans Lao",
	"name" => "Noto Sans Lao",
	"slug" => "noto-sans-lao"
    ) , array(
	"fontFamily" => "Noto Sans Lepcha",
	"name" => "Noto Sans Lepcha",
	"slug" => "noto-sans-lepcha"
    ) , array(
	"fontFamily" => "Noto Sans Limbu",
	"name" => "Noto Sans Limbu",
	"slug" => "noto-sans-limbu"
    ) , array(
	"fontFamily" => "Noto Sans Linear A",
	"name" => "Noto Sans Linear A",
	"slug" => "noto-sans-linear-a"
    ) , array(
	"fontFamily" => "Noto Sans Linear B",
	"name" => "Noto Sans Linear B",
	"slug" => "noto-sans-linear-b"
    ) , array(
	"fontFamily" => "Noto Sans Lisu",
	"name" => "Noto Sans Lisu",
	"slug" => "noto-sans-lisu"
    ) , array(
	"fontFamily" => "Noto Sans Lycian",
	"name" => "Noto Sans Lycian",
	"slug" => "noto-sans-lycian"
    ) , array(
	"fontFamily" => "Noto Sans Lydian",
	"name" => "Noto Sans Lydian",
	"slug" => "noto-sans-lydian"
    ) , array(
	"fontFamily" => "Noto Sans Mahajani",
	"name" => "Noto Sans Mahajani",
	"slug" => "noto-sans-mahajani"
    ) , array(
	"fontFamily" => "Noto Sans Malayalam",
	"name" => "Noto Sans Malayalam",
	"slug" => "noto-sans-malayalam"
    ) , array(
	"fontFamily" => "Noto Sans Mandaic",
	"name" => "Noto Sans Mandaic",
	"slug" => "noto-sans-mandaic"
    ) , array(
	"fontFamily" => "Noto Sans Manichaean",
	"name" => "Noto Sans Manichaean",
	"slug" => "noto-sans-manichaean"
    ) , array(
	"fontFamily" => "Noto Sans Marchen",
	"name" => "Noto Sans Marchen",
	"slug" => "noto-sans-marchen"
    ) , array(
	"fontFamily" => "Noto Sans Masaram Gondi",
	"name" => "Noto Sans Masaram Gondi",
	"slug" => "noto-sans-masaram-gondi"
    ) , array(
	"fontFamily" => "Noto Sans Math",
	"name" => "Noto Sans Math",
	"slug" => "noto-sans-math"
    ) , array(
	"fontFamily" => "Noto Sans Mayan Numerals",
	"name" => "Noto Sans Mayan Numerals",
	"slug" => "noto-sans-mayan-numerals"
    ) , array(
	"fontFamily" => "Noto Sans Medefaidrin",
	"name" => "Noto Sans Medefaidrin",
	"slug" => "noto-sans-medefaidrin"
    ) , array(
	"fontFamily" => "Noto Sans Meetei Mayek",
	"name" => "Noto Sans Meetei Mayek",
	"slug" => "noto-sans-meetei-mayek"
    ) , array(
	"fontFamily" => "Noto Sans Meroitic",
	"name" => "Noto Sans Meroitic",
	"slug" => "noto-sans-meroitic"
    ) , array(
	"fontFamily" => "Noto Sans Miao",
	"name" => "Noto Sans Miao",
	"slug" => "noto-sans-miao"
    ) , array(
	"fontFamily" => "Noto Sans Modi",
	"name" => "Noto Sans Modi",
	"slug" => "noto-sans-modi"
    ) , array(
	"fontFamily" => "Noto Sans Mongolian",
	"name" => "Noto Sans Mongolian",
	"slug" => "noto-sans-mongolian"
    ) , array(
	"fontFamily" => "Noto Sans Mono",
	"name" => "Noto Sans Mono",
	"slug" => "noto-sans-mono"
    ) , array(
	"fontFamily" => "Noto Sans Mro",
	"name" => "Noto Sans Mro",
	"slug" => "noto-sans-mro"
    ) , array(
	"fontFamily" => "Noto Sans Multani",
	"name" => "Noto Sans Multani",
	"slug" => "noto-sans-multani"
    ) , array(
	"fontFamily" => "Noto Sans Myanmar",
	"name" => "Noto Sans Myanmar",
	"slug" => "noto-sans-myanmar"
    ) , array(
	"fontFamily" => "Noto Sans N Ko",
	"name" => "Noto Sans N Ko",
	"slug" => "noto-sans-n-ko"
    ) , array(
	"fontFamily" => "Noto Sans Nabataean",
	"name" => "Noto Sans Nabataean",
	"slug" => "noto-sans-nabataean"
    ) , array(
	"fontFamily" => "Noto Sans New Tai Lue",
	"name" => "Noto Sans New Tai Lue",
	"slug" => "noto-sans-new-tai-lue"
    ) , array(
	"fontFamily" => "Noto Sans Newa",
	"name" => "Noto Sans Newa",
	"slug" => "noto-sans-newa"
    ) , array(
	"fontFamily" => "Noto Sans Nushu",
	"name" => "Noto Sans Nushu",
	"slug" => "noto-sans-nushu"
    ) , array(
	"fontFamily" => "Noto Sans Ogham",
	"name" => "Noto Sans Ogham",
	"slug" => "noto-sans-ogham"
    ) , array(
	"fontFamily" => "Noto Sans Ol Chiki",
	"name" => "Noto Sans Ol Chiki",
	"slug" => "noto-sans-ol-chiki"
    ) , array(
	"fontFamily" => "Noto Sans Old Hungarian",
	"name" => "Noto Sans Old Hungarian",
	"slug" => "noto-sans-old-hungarian"
    ) , array(
	"fontFamily" => "Noto Sans Old Italic",
	"name" => "Noto Sans Old Italic",
	"slug" => "noto-sans-old-italic"
    ) , array(
	"fontFamily" => "Noto Sans Old North Arabian",
	"name" => "Noto Sans Old North Arabian",
	"slug" => "noto-sans-old-north-arabian"
    ) , array(
	"fontFamily" => "Noto Sans Old Permic",
	"name" => "Noto Sans Old Permic",
	"slug" => "noto-sans-old-permic"
    ) , array(
	"fontFamily" => "Noto Sans Old Persian",
	"name" => "Noto Sans Old Persian",
	"slug" => "noto-sans-old-persian"
    ) , array(
	"fontFamily" => "Noto Sans Old Sogdian",
	"name" => "Noto Sans Old Sogdian",
	"slug" => "noto-sans-old-sogdian"
    ) , array(
	"fontFamily" => "Noto Sans Old South Arabian",
	"name" => "Noto Sans Old South Arabian",
	"slug" => "noto-sans-old-south-arabian"
    ) , array(
	"fontFamily" => "Noto Sans Old Turkic",
	"name" => "Noto Sans Old Turkic",
	"slug" => "noto-sans-old-turkic"
    ) , array(
	"fontFamily" => "Noto Sans Oriya",
	"name" => "Noto Sans Oriya",
	"slug" => "noto-sans-oriya"
    ) , array(
	"fontFamily" => "Noto Sans Osage",
	"name" => "Noto Sans Osage",
	"slug" => "noto-sans-osage"
    ) , array(
	"fontFamily" => "Noto Sans Osmanya",
	"name" => "Noto Sans Osmanya",
	"slug" => "noto-sans-osmanya"
    ) , array(
	"fontFamily" => "Noto Sans Pahawh Hmong",
	"name" => "Noto Sans Pahawh Hmong",
	"slug" => "noto-sans-pahawh-hmong"
    ) , array(
	"fontFamily" => "Noto Sans Palmyrene",
	"name" => "Noto Sans Palmyrene",
	"slug" => "noto-sans-palmyrene"
    ) , array(
	"fontFamily" => "Noto Sans Pau Cin Hau",
	"name" => "Noto Sans Pau Cin Hau",
	"slug" => "noto-sans-pau-cin-hau"
    ) , array(
	"fontFamily" => "Noto Sans Phags Pa",
	"name" => "Noto Sans Phags Pa",
	"slug" => "noto-sans-phags-pa"
    ) , array(
	"fontFamily" => "Noto Sans Phoenician",
	"name" => "Noto Sans Phoenician",
	"slug" => "noto-sans-phoenician"
    ) , array(
	"fontFamily" => "Noto Sans Psalter Pahlavi",
	"name" => "Noto Sans Psalter Pahlavi",
	"slug" => "noto-sans-psalter-pahlavi"
    ) , array(
	"fontFamily" => "Noto Sans Rejang",
	"name" => "Noto Sans Rejang",
	"slug" => "noto-sans-rejang"
    ) , array(
	"fontFamily" => "Noto Sans Runic",
	"name" => "Noto Sans Runic",
	"slug" => "noto-sans-runic"
    ) , array(
	"fontFamily" => "Noto Sans SC",
	"name" => "Noto Sans SC",
	"slug" => "noto-sans-sc"
    ) , array(
	"fontFamily" => "Noto Sans Samaritan",
	"name" => "Noto Sans Samaritan",
	"slug" => "noto-sans-samaritan"
    ) , array(
	"fontFamily" => "Noto Sans Saurashtra",
	"name" => "Noto Sans Saurashtra",
	"slug" => "noto-sans-saurashtra"
    ) , array(
	"fontFamily" => "Noto Sans Sharada",
	"name" => "Noto Sans Sharada",
	"slug" => "noto-sans-sharada"
    ) , array(
	"fontFamily" => "Noto Sans Shavian",
	"name" => "Noto Sans Shavian",
	"slug" => "noto-sans-shavian"
    ) , array(
	"fontFamily" => "Noto Sans Siddham",
	"name" => "Noto Sans Siddham",
	"slug" => "noto-sans-siddham"
    ) , array(
	"fontFamily" => "Noto Sans Sinhala",
	"name" => "Noto Sans Sinhala",
	"slug" => "noto-sans-sinhala"
    ) , array(
	"fontFamily" => "Noto Sans Sogdian",
	"name" => "Noto Sans Sogdian",
	"slug" => "noto-sans-sogdian"
    ) , array(
	"fontFamily" => "Noto Sans Sora Sompeng",
	"name" => "Noto Sans Sora Sompeng",
	"slug" => "noto-sans-sora-sompeng"
    ) , array(
	"fontFamily" => "Noto Sans Soyombo",
	"name" => "Noto Sans Soyombo",
	"slug" => "noto-sans-soyombo"
    ) , array(
	"fontFamily" => "Noto Sans Sundanese",
	"name" => "Noto Sans Sundanese",
	"slug" => "noto-sans-sundanese"
    ) , array(
	"fontFamily" => "Noto Sans Syloti Nagri",
	"name" => "Noto Sans Syloti Nagri",
	"slug" => "noto-sans-syloti-nagri"
    ) , array(
	"fontFamily" => "Noto Sans Symbols",
	"name" => "Noto Sans Symbols",
	"slug" => "noto-sans-symbols"
    ) , array(
	"fontFamily" => "Noto Sans Symbols 2",
	"name" => "Noto Sans Symbols 2",
	"slug" => "noto-sans-symbols-2"
    ) , array(
	"fontFamily" => "Noto Sans Syriac",
	"name" => "Noto Sans Syriac",
	"slug" => "noto-sans-syriac"
    ) , array(
	"fontFamily" => "Noto Sans TC",
	"name" => "Noto Sans TC",
	"slug" => "noto-sans-tc"
    ) , array(
	"fontFamily" => "Noto Sans Tagalog",
	"name" => "Noto Sans Tagalog",
	"slug" => "noto-sans-tagalog"
    ) , array(
	"fontFamily" => "Noto Sans Tagbanwa",
	"name" => "Noto Sans Tagbanwa",
	"slug" => "noto-sans-tagbanwa"
    ) , array(
	"fontFamily" => "Noto Sans Tai Le",
	"name" => "Noto Sans Tai Le",
	"slug" => "noto-sans-tai-le"
    ) , array(
	"fontFamily" => "Noto Sans Tai Tham",
	"name" => "Noto Sans Tai Tham",
	"slug" => "noto-sans-tai-tham"
    ) , array(
	"fontFamily" => "Noto Sans Tai Viet",
	"name" => "Noto Sans Tai Viet",
	"slug" => "noto-sans-tai-viet"
    ) , array(
	"fontFamily" => "Noto Sans Takri",
	"name" => "Noto Sans Takri",
	"slug" => "noto-sans-takri"
    ) , array(
	"fontFamily" => "Noto Sans Tamil",
	"name" => "Noto Sans Tamil",
	"slug" => "noto-sans-tamil"
    ) , array(
	"fontFamily" => "Noto Sans Tamil Supplement",
	"name" => "Noto Sans Tamil Supplement",
	"slug" => "noto-sans-tamil-supplement"
    ) , array(
	"fontFamily" => "Noto Sans Telugu",
	"name" => "Noto Sans Telugu",
	"slug" => "noto-sans-telugu"
    ) , array(
	"fontFamily" => "Noto Sans Thaana",
	"name" => "Noto Sans Thaana",
	"slug" => "noto-sans-thaana"
    ) , array(
	"fontFamily" => "Noto Sans Thai",
	"name" => "Noto Sans Thai",
	"slug" => "noto-sans-thai"
    ) , array(
	"fontFamily" => "Noto Sans Thai Looped",
	"name" => "Noto Sans Thai Looped",
	"slug" => "noto-sans-thai-looped"
    ) , array(
	"fontFamily" => "Noto Sans Tifinagh",
	"name" => "Noto Sans Tifinagh",
	"slug" => "noto-sans-tifinagh"
    ) , array(
	"fontFamily" => "Noto Sans Tirhuta",
	"name" => "Noto Sans Tirhuta",
	"slug" => "noto-sans-tirhuta"
    ) , array(
	"fontFamily" => "Noto Sans Ugaritic",
	"name" => "Noto Sans Ugaritic",
	"slug" => "noto-sans-ugaritic"
    ) , array(
	"fontFamily" => "Noto Sans Vai",
	"name" => "Noto Sans Vai",
	"slug" => "noto-sans-vai"
    ) , array(
	"fontFamily" => "Noto Sans Wancho",
	"name" => "Noto Sans Wancho",
	"slug" => "noto-sans-wancho"
    ) , array(
	"fontFamily" => "Noto Sans Warang Citi",
	"name" => "Noto Sans Warang Citi",
	"slug" => "noto-sans-warang-citi"
    ) , array(
	"fontFamily" => "Noto Sans Yi",
	"name" => "Noto Sans Yi",
	"slug" => "noto-sans-yi"
    ) , array(
	"fontFamily" => "Noto Sans Zanabazar Square",
	"name" => "Noto Sans Zanabazar Square",
	"slug" => "noto-sans-zanabazar-square"
    ) , array(
	"fontFamily" => "Noto Serif",
	"name" => "Noto Serif",
	"slug" => "noto-serif"
    ) , array(
	"fontFamily" => "Noto Serif Ahom",
	"name" => "Noto Serif Ahom",
	"slug" => "noto-serif-ahom"
    ) , array(
	"fontFamily" => "Noto Serif Armenian",
	"name" => "Noto Serif Armenian",
	"slug" => "noto-serif-armenian"
    ) , array(
	"fontFamily" => "Noto Serif Balinese",
	"name" => "Noto Serif Balinese",
	"slug" => "noto-serif-balinese"
    ) , array(
	"fontFamily" => "Noto Serif Bengali",
	"name" => "Noto Serif Bengali",
	"slug" => "noto-serif-bengali"
    ) , array(
	"fontFamily" => "Noto Serif Devanagari",
	"name" => "Noto Serif Devanagari",
	"slug" => "noto-serif-devanagari"
    ) , array(
	"fontFamily" => "Noto Serif Display",
	"name" => "Noto Serif Display",
	"slug" => "noto-serif-display"
    ) , array(
	"fontFamily" => "Noto Serif Dogra",
	"name" => "Noto Serif Dogra",
	"slug" => "noto-serif-dogra"
    ) , array(
	"fontFamily" => "Noto Serif Ethiopic",
	"name" => "Noto Serif Ethiopic",
	"slug" => "noto-serif-ethiopic"
    ) , array(
	"fontFamily" => "Noto Serif Georgian",
	"name" => "Noto Serif Georgian",
	"slug" => "noto-serif-georgian"
    ) , array(
	"fontFamily" => "Noto Serif Grantha",
	"name" => "Noto Serif Grantha",
	"slug" => "noto-serif-grantha"
    ) , array(
	"fontFamily" => "Noto Serif Gujarati",
	"name" => "Noto Serif Gujarati",
	"slug" => "noto-serif-gujarati"
    ) , array(
	"fontFamily" => "Noto Serif Gurmukhi",
	"name" => "Noto Serif Gurmukhi",
	"slug" => "noto-serif-gurmukhi"
    ) , array(
	"fontFamily" => "Noto Serif Hebrew",
	"name" => "Noto Serif Hebrew",
	"slug" => "noto-serif-hebrew"
    ) , array(
	"fontFamily" => "Noto Serif JP",
	"name" => "Noto Serif JP",
	"slug" => "noto-serif-jp"
    ) , array(
	"fontFamily" => "Noto Serif KR",
	"name" => "Noto Serif KR",
	"slug" => "noto-serif-kr"
    ) , array(
	"fontFamily" => "Noto Serif Kannada",
	"name" => "Noto Serif Kannada",
	"slug" => "noto-serif-kannada"
    ) , array(
	"fontFamily" => "Noto Serif Khmer",
	"name" => "Noto Serif Khmer",
	"slug" => "noto-serif-khmer"
    ) , array(
	"fontFamily" => "Noto Serif Lao",
	"name" => "Noto Serif Lao",
	"slug" => "noto-serif-lao"
    ) , array(
	"fontFamily" => "Noto Serif Malayalam",
	"name" => "Noto Serif Malayalam",
	"slug" => "noto-serif-malayalam"
    ) , array(
	"fontFamily" => "Noto Serif Myanmar",
	"name" => "Noto Serif Myanmar",
	"slug" => "noto-serif-myanmar"
    ) , array(
	"fontFamily" => "Noto Serif Nyiakeng Puachue Hmong",
	"name" => "Noto Serif Nyiakeng Puachue Hmong",
	"slug" => "noto-serif-nyiakeng-puachue-hmong"
    ) , array(
	"fontFamily" => "Noto Serif SC",
	"name" => "Noto Serif SC",
	"slug" => "noto-serif-sc"
    ) , array(
	"fontFamily" => "Noto Serif Sinhala",
	"name" => "Noto Serif Sinhala",
	"slug" => "noto-serif-sinhala"
    ) , array(
	"fontFamily" => "Noto Serif TC",
	"name" => "Noto Serif TC",
	"slug" => "noto-serif-tc"
    ) , array(
	"fontFamily" => "Noto Serif Tamil",
	"name" => "Noto Serif Tamil",
	"slug" => "noto-serif-tamil"
    ) , array(
	"fontFamily" => "Noto Serif Tangut",
	"name" => "Noto Serif Tangut",
	"slug" => "noto-serif-tangut"
    ) , array(
	"fontFamily" => "Noto Serif Telugu",
	"name" => "Noto Serif Telugu",
	"slug" => "noto-serif-telugu"
    ) , array(
	"fontFamily" => "Noto Serif Thai",
	"name" => "Noto Serif Thai",
	"slug" => "noto-serif-thai"
    ) , array(
	"fontFamily" => "Noto Serif Tibetan",
	"name" => "Noto Serif Tibetan",
	"slug" => "noto-serif-tibetan"
    ) , array(
	"fontFamily" => "Noto Serif Yezidi",
	"name" => "Noto Serif Yezidi",
	"slug" => "noto-serif-yezidi"
    ) , array(
	"fontFamily" => "Noto Traditional Nushu",
	"name" => "Noto Traditional Nushu",
	"slug" => "noto-traditional-nushu"
    ) , array(
	"fontFamily" => "Nova Cut",
	"name" => "Nova Cut",
	"slug" => "nova-cut"
    ) , array(
	"fontFamily" => "Nova Flat",
	"name" => "Nova Flat",
	"slug" => "nova-flat"
    ) , array(
	"fontFamily" => "Nova Mono",
	"name" => "Nova Mono",
	"slug" => "nova-mono"
    ) , array(
	"fontFamily" => "Nova Oval",
	"name" => "Nova Oval",
	"slug" => "nova-oval"
    ) , array(
	"fontFamily" => "Nova Round",
	"name" => "Nova Round",
	"slug" => "nova-round"
    ) , array(
	"fontFamily" => "Nova Script",
	"name" => "Nova Script",
	"slug" => "nova-script"
    ) , array(
	"fontFamily" => "Nova Slim",
	"name" => "Nova Slim",
	"slug" => "nova-slim"
    ) , array(
	"fontFamily" => "Nova Square",
	"name" => "Nova Square",
	"slug" => "nova-square"
    ) , array(
	"fontFamily" => "Numans",
	"name" => "Numans",
	"slug" => "numans"
    ) , array(
	"fontFamily" => "Nunito",
	"name" => "Nunito",
	"slug" => "nunito"
    ) , array(
	"fontFamily" => "Nunito Sans",
	"name" => "Nunito Sans",
	"slug" => "nunito-sans"
    ) , array(
	"fontFamily" => "Odibee Sans",
	"name" => "Odibee Sans",
	"slug" => "odibee-sans"
    ) , array(
	"fontFamily" => "Odor Mean Chey",
	"name" => "Odor Mean Chey",
	"slug" => "odor-mean-chey"
    ) , array(
	"fontFamily" => "Offside",
	"name" => "Offside",
	"slug" => "offside"
    ) , array(
	"fontFamily" => "Oi",
	"name" => "Oi",
	"slug" => "oi"
    ) , array(
	"fontFamily" => "Old Standard TT",
	"name" => "Old Standard TT",
	"slug" => "old-standard-tt"
    ) , array(
	"fontFamily" => "Oldenburg",
	"name" => "Oldenburg",
	"slug" => "oldenburg"
    ) , array(
	"fontFamily" => "Ole",
	"name" => "Ole",
	"slug" => "ole"
    ) , array(
	"fontFamily" => "Oleo Script",
	"name" => "Oleo Script",
	"slug" => "oleo-script"
    ) , array(
	"fontFamily" => "Oleo Script Swash Caps",
	"name" => "Oleo Script Swash Caps",
	"slug" => "oleo-script-swash-caps"
    ) , array(
	"fontFamily" => "Oooh Baby",
	"name" => "Oooh Baby",
	"slug" => "oooh-baby"
    ) , array(
	"fontFamily" => "Open Sans",
	"name" => "Open Sans",
	"slug" => "open-sans"
    ) , array(
	"fontFamily" => "Open Sans Condensed",
	"name" => "Open Sans Condensed",
	"slug" => "open-sans-condensed"
    ) , array(
	"fontFamily" => "Oranienbaum",
	"name" => "Oranienbaum",
	"slug" => "oranienbaum"
    ) , array(
	"fontFamily" => "Orbitron",
	"name" => "Orbitron",
	"slug" => "orbitron"
    ) , array(
	"fontFamily" => "Oregano",
	"name" => "Oregano",
	"slug" => "oregano"
    ) , array(
	"fontFamily" => "Orelega One",
	"name" => "Orelega One",
	"slug" => "orelega-one"
    ) , array(
	"fontFamily" => "Orienta",
	"name" => "Orienta",
	"slug" => "orienta"
    ) , array(
	"fontFamily" => "Original Surfer",
	"name" => "Original Surfer",
	"slug" => "original-surfer"
    ) , array(
	"fontFamily" => "Oswald",
	"name" => "Oswald",
	"slug" => "oswald"
    ) , array(
	"fontFamily" => "Otomanopee One",
	"name" => "Otomanopee One",
	"slug" => "otomanopee-one"
    ) , array(
	"fontFamily" => "Outfit",
	"name" => "Outfit",
	"slug" => "outfit"
    ) , array(
	"fontFamily" => "Over the Rainbow",
	"name" => "Over the Rainbow",
	"slug" => "over-the-rainbow"
    ) , array(
	"fontFamily" => "Overlock",
	"name" => "Overlock",
	"slug" => "overlock"
    ) , array(
	"fontFamily" => "Overlock SC",
	"name" => "Overlock SC",
	"slug" => "overlock-sc"
    ) , array(
	"fontFamily" => "Overpass",
	"name" => "Overpass",
	"slug" => "overpass"
    ) , array(
	"fontFamily" => "Overpass Mono",
	"name" => "Overpass Mono",
	"slug" => "overpass-mono"
    ) , array(
	"fontFamily" => "Ovo",
	"name" => "Ovo",
	"slug" => "ovo"
    ) , array(
	"fontFamily" => "Oxanium",
	"name" => "Oxanium",
	"slug" => "oxanium"
    ) , array(
	"fontFamily" => "Oxygen",
	"name" => "Oxygen",
	"slug" => "oxygen"
    ) , array(
	"fontFamily" => "Oxygen Mono",
	"name" => "Oxygen Mono",
	"slug" => "oxygen-mono"
    ) , array(
	"fontFamily" => "PT Mono",
	"name" => "PT Mono",
	"slug" => "pt-mono"
    ) , array(
	"fontFamily" => "PT Sans",
	"name" => "PT Sans",
	"slug" => "pt-sans"
    ) , array(
	"fontFamily" => "PT Sans Caption",
	"name" => "PT Sans Caption",
	"slug" => "pt-sans-caption"
    ) , array(
	"fontFamily" => "PT Sans Narrow",
	"name" => "PT Sans Narrow",
	"slug" => "pt-sans-narrow"
    ) , array(
	"fontFamily" => "PT Serif",
	"name" => "PT Serif",
	"slug" => "pt-serif"
    ) , array(
	"fontFamily" => "PT Serif Caption",
	"name" => "PT Serif Caption",
	"slug" => "pt-serif-caption"
    ) , array(
	"fontFamily" => "Pacifico",
	"name" => "Pacifico",
	"slug" => "pacifico"
    ) , array(
	"fontFamily" => "Padauk",
	"name" => "Padauk",
	"slug" => "padauk"
    ) , array(
	"fontFamily" => "Palanquin",
	"name" => "Palanquin",
	"slug" => "palanquin"
    ) , array(
	"fontFamily" => "Palanquin Dark",
	"name" => "Palanquin Dark",
	"slug" => "palanquin-dark"
    ) , array(
	"fontFamily" => "Palette Mosaic",
	"name" => "Palette Mosaic",
	"slug" => "palette-mosaic"
    ) , array(
	"fontFamily" => "Pangolin",
	"name" => "Pangolin",
	"slug" => "pangolin"
    ) , array(
	"fontFamily" => "Paprika",
	"name" => "Paprika",
	"slug" => "paprika"
    ) , array(
	"fontFamily" => "Parisienne",
	"name" => "Parisienne",
	"slug" => "parisienne"
    ) , array(
	"fontFamily" => "Passero One",
	"name" => "Passero One",
	"slug" => "passero-one"
    ) , array(
	"fontFamily" => "Passion One",
	"name" => "Passion One",
	"slug" => "passion-one"
    ) , array(
	"fontFamily" => "Passions Conflict",
	"name" => "Passions Conflict",
	"slug" => "passions-conflict"
    ) , array(
	"fontFamily" => "Pathway Gothic One",
	"name" => "Pathway Gothic One",
	"slug" => "pathway-gothic-one"
    ) , array(
	"fontFamily" => "Patrick Hand",
	"name" => "Patrick Hand",
	"slug" => "patrick-hand"
    ) , array(
	"fontFamily" => "Patrick Hand SC",
	"name" => "Patrick Hand SC",
	"slug" => "patrick-hand-sc"
    ) , array(
	"fontFamily" => "Pattaya",
	"name" => "Pattaya",
	"slug" => "pattaya"
    ) , array(
	"fontFamily" => "Patua One",
	"name" => "Patua One",
	"slug" => "patua-one"
    ) , array(
	"fontFamily" => "Pavanam",
	"name" => "Pavanam",
	"slug" => "pavanam"
    ) , array(
	"fontFamily" => "Paytone One",
	"name" => "Paytone One",
	"slug" => "paytone-one"
    ) , array(
	"fontFamily" => "Peddana",
	"name" => "Peddana",
	"slug" => "peddana"
    ) , array(
	"fontFamily" => "Peralta",
	"name" => "Peralta",
	"slug" => "peralta"
    ) , array(
	"fontFamily" => "Permanent Marker",
	"name" => "Permanent Marker",
	"slug" => "permanent-marker"
    ) , array(
	"fontFamily" => "Petemoss",
	"name" => "Petemoss",
	"slug" => "petemoss"
    ) , array(
	"fontFamily" => "Petit Formal Script",
	"name" => "Petit Formal Script",
	"slug" => "petit-formal-script"
    ) , array(
	"fontFamily" => "Petrona",
	"name" => "Petrona",
	"slug" => "petrona"
    ) , array(
	"fontFamily" => "Philosopher",
	"name" => "Philosopher",
	"slug" => "philosopher"
    ) , array(
	"fontFamily" => "Piazzolla",
	"name" => "Piazzolla",
	"slug" => "piazzolla"
    ) , array(
	"fontFamily" => "Piedra",
	"name" => "Piedra",
	"slug" => "piedra"
    ) , array(
	"fontFamily" => "Pinyon Script",
	"name" => "Pinyon Script",
	"slug" => "pinyon-script"
    ) , array(
	"fontFamily" => "Pirata One",
	"name" => "Pirata One",
	"slug" => "pirata-one"
    ) , array(
	"fontFamily" => "Plaster",
	"name" => "Plaster",
	"slug" => "plaster"
    ) , array(
	"fontFamily" => "Play",
	"name" => "Play",
	"slug" => "play"
    ) , array(
	"fontFamily" => "Playball",
	"name" => "Playball",
	"slug" => "playball"
    ) , array(
	"fontFamily" => "Playfair Display",
	"name" => "Playfair Display",
	"slug" => "playfair-display"
    ) , array(
	"fontFamily" => "Playfair Display SC",
	"name" => "Playfair Display SC",
	"slug" => "playfair-display-sc"
    ) , array(
	"fontFamily" => "Podkova",
	"name" => "Podkova",
	"slug" => "podkova"
    ) , array(
	"fontFamily" => "Poiret One",
	"name" => "Poiret One",
	"slug" => "poiret-one"
    ) , array(
	"fontFamily" => "Poller One",
	"name" => "Poller One",
	"slug" => "poller-one"
    ) , array(
	"fontFamily" => "Poly",
	"name" => "Poly",
	"slug" => "poly"
    ) , array(
	"fontFamily" => "Pompiere",
	"name" => "Pompiere",
	"slug" => "pompiere"
    ) , array(
	"fontFamily" => "Pontano Sans",
	"name" => "Pontano Sans",
	"slug" => "pontano-sans"
    ) , array(
	"fontFamily" => "Poor Story",
	"name" => "Poor Story",
	"slug" => "poor-story"
    ) , array(
	"fontFamily" => "Poppins",
	"name" => "Poppins",
	"slug" => "poppins"
    ) , array(
	"fontFamily" => "Port Lligat Sans",
	"name" => "Port Lligat Sans",
	"slug" => "port-lligat-sans"
    ) , array(
	"fontFamily" => "Port Lligat Slab",
	"name" => "Port Lligat Slab",
	"slug" => "port-lligat-slab"
    ) , array(
	"fontFamily" => "Potta One",
	"name" => "Potta One",
	"slug" => "potta-one"
    ) , array(
	"fontFamily" => "Pragati Narrow",
	"name" => "Pragati Narrow",
	"slug" => "pragati-narrow"
    ) , array(
	"fontFamily" => "Praise",
	"name" => "Praise",
	"slug" => "praise"
    ) , array(
	"fontFamily" => "Prata",
	"name" => "Prata",
	"slug" => "prata"
    ) , array(
	"fontFamily" => "Preahvihear",
	"name" => "Preahvihear",
	"slug" => "preahvihear"
    ) , array(
	"fontFamily" => "Press Start 2P",
	"name" => "Press Start 2P",
	"slug" => "press-start-2p"
    ) , array(
	"fontFamily" => "Pridi",
	"name" => "Pridi",
	"slug" => "pridi"
    ) , array(
	"fontFamily" => "Princess Sofia",
	"name" => "Princess Sofia",
	"slug" => "princess-sofia"
    ) , array(
	"fontFamily" => "Prociono",
	"name" => "Prociono",
	"slug" => "prociono"
    ) , array(
	"fontFamily" => "Prompt",
	"name" => "Prompt",
	"slug" => "prompt"
    ) , array(
	"fontFamily" => "Prosto One",
	"name" => "Prosto One",
	"slug" => "prosto-one"
    ) , array(
	"fontFamily" => "Proza Libre",
	"name" => "Proza Libre",
	"slug" => "proza-libre"
    ) , array(
	"fontFamily" => "Public Sans",
	"name" => "Public Sans",
	"slug" => "public-sans"
    ) , array(
	"fontFamily" => "Puppies Play",
	"name" => "Puppies Play",
	"slug" => "puppies-play"
    ) , array(
	"fontFamily" => "Puritan",
	"name" => "Puritan",
	"slug" => "puritan"
    ) , array(
	"fontFamily" => "Purple Purse",
	"name" => "Purple Purse",
	"slug" => "purple-purse"
    ) , array(
	"fontFamily" => "Qahiri",
	"name" => "Qahiri",
	"slug" => "qahiri"
    ) , array(
	"fontFamily" => "Quando",
	"name" => "Quando",
	"slug" => "quando"
    ) , array(
	"fontFamily" => "Quantico",
	"name" => "Quantico",
	"slug" => "quantico"
    ) , array(
	"fontFamily" => "Quattrocento",
	"name" => "Quattrocento",
	"slug" => "quattrocento"
    ) , array(
	"fontFamily" => "Quattrocento Sans",
	"name" => "Quattrocento Sans",
	"slug" => "quattrocento-sans"
    ) , array(
	"fontFamily" => "Questrial",
	"name" => "Questrial",
	"slug" => "questrial"
    ) , array(
	"fontFamily" => "Quicksand",
	"name" => "Quicksand",
	"slug" => "quicksand"
    ) , array(
	"fontFamily" => "Quintessential",
	"name" => "Quintessential",
	"slug" => "quintessential"
    ) , array(
	"fontFamily" => "Qwigley",
	"name" => "Qwigley",
	"slug" => "qwigley"
    ) , array(
	"fontFamily" => "Qwitcher Grypen",
	"name" => "Qwitcher Grypen",
	"slug" => "qwitcher-grypen"
    ) , array(
	"fontFamily" => "Racing Sans One",
	"name" => "Racing Sans One",
	"slug" => "racing-sans-one"
    ) , array(
	"fontFamily" => "Radley",
	"name" => "Radley",
	"slug" => "radley"
    ) , array(
	"fontFamily" => "Rajdhani",
	"name" => "Rajdhani",
	"slug" => "rajdhani"
    ) , array(
	"fontFamily" => "Rakkas",
	"name" => "Rakkas",
	"slug" => "rakkas"
    ) , array(
	"fontFamily" => "Raleway",
	"name" => "Raleway",
	"slug" => "raleway"
    ) , array(
	"fontFamily" => "Raleway Dots",
	"name" => "Raleway Dots",
	"slug" => "raleway-dots"
    ) , array(
	"fontFamily" => "Ramabhadra",
	"name" => "Ramabhadra",
	"slug" => "ramabhadra"
    ) , array(
	"fontFamily" => "Ramaraja",
	"name" => "Ramaraja",
	"slug" => "ramaraja"
    ) , array(
	"fontFamily" => "Rambla",
	"name" => "Rambla",
	"slug" => "rambla"
    ) , array(
	"fontFamily" => "Rammetto One",
	"name" => "Rammetto One",
	"slug" => "rammetto-one"
    ) , array(
	"fontFamily" => "Rampart One",
	"name" => "Rampart One",
	"slug" => "rampart-one"
    ) , array(
	"fontFamily" => "Ranchers",
	"name" => "Ranchers",
	"slug" => "ranchers"
    ) , array(
	"fontFamily" => "Rancho",
	"name" => "Rancho",
	"slug" => "rancho"
    ) , array(
	"fontFamily" => "Ranga",
	"name" => "Ranga",
	"slug" => "ranga"
    ) , array(
	"fontFamily" => "Rasa",
	"name" => "Rasa",
	"slug" => "rasa"
    ) , array(
	"fontFamily" => "Rationale",
	"name" => "Rationale",
	"slug" => "rationale"
    ) , array(
	"fontFamily" => "Ravi Prakash",
	"name" => "Ravi Prakash",
	"slug" => "ravi-prakash"
    ) , array(
	"fontFamily" => "Readex Pro",
	"name" => "Readex Pro",
	"slug" => "readex-pro"
    ) , array(
	"fontFamily" => "Recursive",
	"name" => "Recursive",
	"slug" => "recursive"
    ) , array(
	"fontFamily" => "Red Hat Display",
	"name" => "Red Hat Display",
	"slug" => "red-hat-display"
    ) , array(
	"fontFamily" => "Red Hat Mono",
	"name" => "Red Hat Mono",
	"slug" => "red-hat-mono"
    ) , array(
	"fontFamily" => "Red Hat Text",
	"name" => "Red Hat Text",
	"slug" => "red-hat-text"
    ) , array(
	"fontFamily" => "Red Rose",
	"name" => "Red Rose",
	"slug" => "red-rose"
    ) , array(
	"fontFamily" => "Redacted",
	"name" => "Redacted",
	"slug" => "redacted"
    ) , array(
	"fontFamily" => "Redacted Script",
	"name" => "Redacted Script",
	"slug" => "redacted-script"
    ) , array(
	"fontFamily" => "Redressed",
	"name" => "Redressed",
	"slug" => "redressed"
    ) , array(
	"fontFamily" => "Reem Kufi",
	"name" => "Reem Kufi",
	"slug" => "reem-kufi"
    ) , array(
	"fontFamily" => "Reenie Beanie",
	"name" => "Reenie Beanie",
	"slug" => "reenie-beanie"
    ) , array(
	"fontFamily" => "Reggae One",
	"name" => "Reggae One",
	"slug" => "reggae-one"
    ) , array(
	"fontFamily" => "Revalia",
	"name" => "Revalia",
	"slug" => "revalia"
    ) , array(
	"fontFamily" => "Rhodium Libre",
	"name" => "Rhodium Libre",
	"slug" => "rhodium-libre"
    ) , array(
	"fontFamily" => "Ribeye",
	"name" => "Ribeye",
	"slug" => "ribeye"
    ) , array(
	"fontFamily" => "Ribeye Marrow",
	"name" => "Ribeye Marrow",
	"slug" => "ribeye-marrow"
    ) , array(
	"fontFamily" => "Righteous",
	"name" => "Righteous",
	"slug" => "righteous"
    ) , array(
	"fontFamily" => "Risque",
	"name" => "Risque",
	"slug" => "risque"
    ) , array(
	"fontFamily" => "Road Rage",
	"name" => "Road Rage",
	"slug" => "road-rage"
    ) , array(
	"fontFamily" => "Roboto",
	"name" => "Roboto",
	"slug" => "roboto"
    ) , array(
	"fontFamily" => "Roboto Condensed",
	"name" => "Roboto Condensed",
	"slug" => "roboto-condensed"
    ) , array(
	"fontFamily" => "Roboto Mono",
	"name" => "Roboto Mono",
	"slug" => "roboto-mono"
    ) , array(
	"fontFamily" => "Roboto Slab",
	"name" => "Roboto Slab",
	"slug" => "roboto-slab"
    ) , array(
	"fontFamily" => "Rochester",
	"name" => "Rochester",
	"slug" => "rochester"
    ) , array(
	"fontFamily" => "Rock 3D",
	"name" => "Rock 3D",
	"slug" => "rock-3d"
    ) , array(
	"fontFamily" => "Rock Salt",
	"name" => "Rock Salt",
	"slug" => "rock-salt"
    ) , array(
	"fontFamily" => "RocknRoll One",
	"name" => "RocknRoll One",
	"slug" => "rocknroll-one"
    ) , array(
	"fontFamily" => "Rokkitt",
	"name" => "Rokkitt",
	"slug" => "rokkitt"
    ) , array(
	"fontFamily" => "Romanesco",
	"name" => "Romanesco",
	"slug" => "romanesco"
    ) , array(
	"fontFamily" => "Ropa Sans",
	"name" => "Ropa Sans",
	"slug" => "ropa-sans"
    ) , array(
	"fontFamily" => "Rosario",
	"name" => "Rosario",
	"slug" => "rosario"
    ) , array(
	"fontFamily" => "Rosarivo",
	"name" => "Rosarivo",
	"slug" => "rosarivo"
    ) , array(
	"fontFamily" => "Rouge Script",
	"name" => "Rouge Script",
	"slug" => "rouge-script"
    ) , array(
	"fontFamily" => "Rowdies",
	"name" => "Rowdies",
	"slug" => "rowdies"
    ) , array(
	"fontFamily" => "Rozha One",
	"name" => "Rozha One",
	"slug" => "rozha-one"
    ) , array(
	"fontFamily" => "Rubik",
	"name" => "Rubik",
	"slug" => "rubik"
    ) , array(
	"fontFamily" => "Rubik Beastly",
	"name" => "Rubik Beastly",
	"slug" => "rubik-beastly"
    ) , array(
	"fontFamily" => "Rubik Mono One",
	"name" => "Rubik Mono One",
	"slug" => "rubik-mono-one"
    ) , array(
	"fontFamily" => "Ruda",
	"name" => "Ruda",
	"slug" => "ruda"
    ) , array(
	"fontFamily" => "Rufina",
	"name" => "Rufina",
	"slug" => "rufina"
    ) , array(
	"fontFamily" => "Ruge Boogie",
	"name" => "Ruge Boogie",
	"slug" => "ruge-boogie"
    ) , array(
	"fontFamily" => "Ruluko",
	"name" => "Ruluko",
	"slug" => "ruluko"
    ) , array(
	"fontFamily" => "Rum Raisin",
	"name" => "Rum Raisin",
	"slug" => "rum-raisin"
    ) , array(
	"fontFamily" => "Ruslan Display",
	"name" => "Ruslan Display",
	"slug" => "ruslan-display"
    ) , array(
	"fontFamily" => "Russo One",
	"name" => "Russo One",
	"slug" => "russo-one"
    ) , array(
	"fontFamily" => "Ruthie",
	"name" => "Ruthie",
	"slug" => "ruthie"
    ) , array(
	"fontFamily" => "Rye",
	"name" => "Rye",
	"slug" => "rye"
    ) , array(
	"fontFamily" => "STIX Two Text",
	"name" => "STIX Two Text",
	"slug" => "stix-two-text"
    ) , array(
	"fontFamily" => "Sacramento",
	"name" => "Sacramento",
	"slug" => "sacramento"
    ) , array(
	"fontFamily" => "Sahitya",
	"name" => "Sahitya",
	"slug" => "sahitya"
    ) , array(
	"fontFamily" => "Sail",
	"name" => "Sail",
	"slug" => "sail"
    ) , array(
	"fontFamily" => "Saira",
	"name" => "Saira",
	"slug" => "saira"
    ) , array(
	"fontFamily" => "Saira Condensed",
	"name" => "Saira Condensed",
	"slug" => "saira-condensed"
    ) , array(
	"fontFamily" => "Saira Extra Condensed",
	"name" => "Saira Extra Condensed",
	"slug" => "saira-extra-condensed"
    ) , array(
	"fontFamily" => "Saira Semi Condensed",
	"name" => "Saira Semi Condensed",
	"slug" => "saira-semi-condensed"
    ) , array(
	"fontFamily" => "Saira Stencil One",
	"name" => "Saira Stencil One",
	"slug" => "saira-stencil-one"
    ) , array(
	"fontFamily" => "Salsa",
	"name" => "Salsa",
	"slug" => "salsa"
    ) , array(
	"fontFamily" => "Sanchez",
	"name" => "Sanchez",
	"slug" => "sanchez"
    ) , array(
	"fontFamily" => "Sancreek",
	"name" => "Sancreek",
	"slug" => "sancreek"
    ) , array(
	"fontFamily" => "Sansita",
	"name" => "Sansita",
	"slug" => "sansita"
    ) , array(
	"fontFamily" => "Sansita Swashed",
	"name" => "Sansita Swashed",
	"slug" => "sansita-swashed"
    ) , array(
	"fontFamily" => "Sarabun",
	"name" => "Sarabun",
	"slug" => "sarabun"
    ) , array(
	"fontFamily" => "Sarala",
	"name" => "Sarala",
	"slug" => "sarala"
    ) , array(
	"fontFamily" => "Sarina",
	"name" => "Sarina",
	"slug" => "sarina"
    ) , array(
	"fontFamily" => "Sarpanch",
	"name" => "Sarpanch",
	"slug" => "sarpanch"
    ) , array(
	"fontFamily" => "Sassy Frass",
	"name" => "Sassy Frass",
	"slug" => "sassy-frass"
    ) , array(
	"fontFamily" => "Satisfy",
	"name" => "Satisfy",
	"slug" => "satisfy"
    ) , array(
	"fontFamily" => "Sawarabi Gothic",
	"name" => "Sawarabi Gothic",
	"slug" => "sawarabi-gothic"
    ) , array(
	"fontFamily" => "Sawarabi Mincho",
	"name" => "Sawarabi Mincho",
	"slug" => "sawarabi-mincho"
    ) , array(
	"fontFamily" => "Scada",
	"name" => "Scada",
	"slug" => "scada"
    ) , array(
	"fontFamily" => "Scheherazade New",
	"name" => "Scheherazade New",
	"slug" => "scheherazade-new"
    ) , array(
	"fontFamily" => "Schoolbell",
	"name" => "Schoolbell",
	"slug" => "schoolbell"
    ) , array(
	"fontFamily" => "Scope One",
	"name" => "Scope One",
	"slug" => "scope-one"
    ) , array(
	"fontFamily" => "Seaweed Script",
	"name" => "Seaweed Script",
	"slug" => "seaweed-script"
    ) , array(
	"fontFamily" => "Secular One",
	"name" => "Secular One",
	"slug" => "secular-one"
    ) , array(
	"fontFamily" => "Sedgwick Ave",
	"name" => "Sedgwick Ave",
	"slug" => "sedgwick-ave"
    ) , array(
	"fontFamily" => "Sedgwick Ave Display",
	"name" => "Sedgwick Ave Display",
	"slug" => "sedgwick-ave-display"
    ) , array(
	"fontFamily" => "Sen",
	"name" => "Sen",
	"slug" => "sen"
    ) , array(
	"fontFamily" => "Sevillana",
	"name" => "Sevillana",
	"slug" => "sevillana"
    ) , array(
	"fontFamily" => "Seymour One",
	"name" => "Seymour One",
	"slug" => "seymour-one"
    ) , array(
	"fontFamily" => "Shadows Into Light",
	"name" => "Shadows Into Light",
	"slug" => "shadows-into-light"
    ) , array(
	"fontFamily" => "Shadows Into Light Two",
	"name" => "Shadows Into Light Two",
	"slug" => "shadows-into-light-two"
    ) , array(
	"fontFamily" => "Shalimar",
	"name" => "Shalimar",
	"slug" => "shalimar"
    ) , array(
	"fontFamily" => "Shanti",
	"name" => "Shanti",
	"slug" => "shanti"
    ) , array(
	"fontFamily" => "Share",
	"name" => "Share",
	"slug" => "share"
    ) , array(
	"fontFamily" => "Share Tech",
	"name" => "Share Tech",
	"slug" => "share-tech"
    ) , array(
	"fontFamily" => "Share Tech Mono",
	"name" => "Share Tech Mono",
	"slug" => "share-tech-mono"
    ) , array(
	"fontFamily" => "Shippori Antique",
	"name" => "Shippori Antique",
	"slug" => "shippori-antique"
    ) , array(
	"fontFamily" => "Shippori Antique B1",
	"name" => "Shippori Antique B1",
	"slug" => "shippori-antique-b1"
    ) , array(
	"fontFamily" => "Shippori Mincho",
	"name" => "Shippori Mincho",
	"slug" => "shippori-mincho"
    ) , array(
	"fontFamily" => "Shippori Mincho B1",
	"name" => "Shippori Mincho B1",
	"slug" => "shippori-mincho-b1"
    ) , array(
	"fontFamily" => "Shizuru",
	"name" => "Shizuru",
	"slug" => "shizuru"
    ) , array(
	"fontFamily" => "Shojumaru",
	"name" => "Shojumaru",
	"slug" => "shojumaru"
    ) , array(
	"fontFamily" => "Short Stack",
	"name" => "Short Stack",
	"slug" => "short-stack"
    ) , array(
	"fontFamily" => "Shrikhand",
	"name" => "Shrikhand",
	"slug" => "shrikhand"
    ) , array(
	"fontFamily" => "Siemreap",
	"name" => "Siemreap",
	"slug" => "siemreap"
    ) , array(
	"fontFamily" => "Sigmar One",
	"name" => "Sigmar One",
	"slug" => "sigmar-one"
    ) , array(
	"fontFamily" => "Signika",
	"name" => "Signika",
	"slug" => "signika"
    ) , array(
	"fontFamily" => "Signika Negative",
	"name" => "Signika Negative",
	"slug" => "signika-negative"
    ) , array(
	"fontFamily" => "Simonetta",
	"name" => "Simonetta",
	"slug" => "simonetta"
    ) , array(
	"fontFamily" => "Single Day",
	"name" => "Single Day",
	"slug" => "single-day"
    ) , array(
	"fontFamily" => "Sintony",
	"name" => "Sintony",
	"slug" => "sintony"
    ) , array(
	"fontFamily" => "Sirin Stencil",
	"name" => "Sirin Stencil",
	"slug" => "sirin-stencil"
    ) , array(
	"fontFamily" => "Six Caps",
	"name" => "Six Caps",
	"slug" => "six-caps"
    ) , array(
	"fontFamily" => "Skranji",
	"name" => "Skranji",
	"slug" => "skranji"
    ) , array(
	"fontFamily" => "Slabo 13px",
	"name" => "Slabo 13px",
	"slug" => "slabo-13px"
    ) , array(
	"fontFamily" => "Slabo 27px",
	"name" => "Slabo 27px",
	"slug" => "slabo-27px"
    ) , array(
	"fontFamily" => "Slackey",
	"name" => "Slackey",
	"slug" => "slackey"
    ) , array(
	"fontFamily" => "Smokum",
	"name" => "Smokum",
	"slug" => "smokum"
    ) , array(
	"fontFamily" => "Smooch",
	"name" => "Smooch",
	"slug" => "smooch"
    ) , array(
	"fontFamily" => "Smythe",
	"name" => "Smythe",
	"slug" => "smythe"
    ) , array(
	"fontFamily" => "Sniglet",
	"name" => "Sniglet",
	"slug" => "sniglet"
    ) , array(
	"fontFamily" => "Snippet",
	"name" => "Snippet",
	"slug" => "snippet"
    ) , array(
	"fontFamily" => "Snowburst One",
	"name" => "Snowburst One",
	"slug" => "snowburst-one"
    ) , array(
	"fontFamily" => "Sofadi One",
	"name" => "Sofadi One",
	"slug" => "sofadi-one"
    ) , array(
	"fontFamily" => "Sofia",
	"name" => "Sofia",
	"slug" => "sofia"
    ) , array(
	"fontFamily" => "Solway",
	"name" => "Solway",
	"slug" => "solway"
    ) , array(
	"fontFamily" => "Song Myung",
	"name" => "Song Myung",
	"slug" => "song-myung"
    ) , array(
	"fontFamily" => "Sonsie One",
	"name" => "Sonsie One",
	"slug" => "sonsie-one"
    ) , array(
	"fontFamily" => "Sora",
	"name" => "Sora",
	"slug" => "sora"
    ) , array(
	"fontFamily" => "Sorts Mill Goudy",
	"name" => "Sorts Mill Goudy",
	"slug" => "sorts-mill-goudy"
    ) , array(
	"fontFamily" => "Source Code Pro",
	"name" => "Source Code Pro",
	"slug" => "source-code-pro"
    ) , array(
	"fontFamily" => "Source Sans 3",
	"name" => "Source Sans 3",
	"slug" => "source-sans-3"
    ) , array(
	"fontFamily" => "Source Sans Pro",
	"name" => "Source Sans Pro",
	"slug" => "source-sans-pro"
    ) , array(
	"fontFamily" => "Source Serif 4",
	"name" => "Source Serif 4",
	"slug" => "source-serif-4"
    ) , array(
	"fontFamily" => "Source Serif Pro",
	"name" => "Source Serif Pro",
	"slug" => "source-serif-pro"
    ) , array(
	"fontFamily" => "Space Grotesk",
	"name" => "Space Grotesk",
	"slug" => "space-grotesk"
    ) , array(
	"fontFamily" => "Space Mono",
	"name" => "Space Mono",
	"slug" => "space-mono"
    ) , array(
	"fontFamily" => "Spartan",
	"name" => "Spartan",
	"slug" => "spartan"
    ) , array(
	"fontFamily" => "Special Elite",
	"name" => "Special Elite",
	"slug" => "special-elite"
    ) , array(
	"fontFamily" => "Spectral",
	"name" => "Spectral",
	"slug" => "spectral"
    ) , array(
	"fontFamily" => "Spectral SC",
	"name" => "Spectral SC",
	"slug" => "spectral-sc"
    ) , array(
	"fontFamily" => "Spicy Rice",
	"name" => "Spicy Rice",
	"slug" => "spicy-rice"
    ) , array(
	"fontFamily" => "Spinnaker",
	"name" => "Spinnaker",
	"slug" => "spinnaker"
    ) , array(
	"fontFamily" => "Spirax",
	"name" => "Spirax",
	"slug" => "spirax"
    ) , array(
	"fontFamily" => "Spline Sans",
	"name" => "Spline Sans",
	"slug" => "spline-sans"
    ) , array(
	"fontFamily" => "Squada One",
	"name" => "Squada One",
	"slug" => "squada-one"
    ) , array(
	"fontFamily" => "Sree Krushnadevaraya",
	"name" => "Sree Krushnadevaraya",
	"slug" => "sree-krushnadevaraya"
    ) , array(
	"fontFamily" => "Sriracha",
	"name" => "Sriracha",
	"slug" => "sriracha"
    ) , array(
	"fontFamily" => "Srisakdi",
	"name" => "Srisakdi",
	"slug" => "srisakdi"
    ) , array(
	"fontFamily" => "Staatliches",
	"name" => "Staatliches",
	"slug" => "staatliches"
    ) , array(
	"fontFamily" => "Stalemate",
	"name" => "Stalemate",
	"slug" => "stalemate"
    ) , array(
	"fontFamily" => "Stalinist One",
	"name" => "Stalinist One",
	"slug" => "stalinist-one"
    ) , array(
	"fontFamily" => "Stardos Stencil",
	"name" => "Stardos Stencil",
	"slug" => "stardos-stencil"
    ) , array(
	"fontFamily" => "Stick",
	"name" => "Stick",
	"slug" => "stick"
    ) , array(
	"fontFamily" => "Stick No Bills",
	"name" => "Stick No Bills",
	"slug" => "stick-no-bills"
    ) , array(
	"fontFamily" => "Stint Ultra Condensed",
	"name" => "Stint Ultra Condensed",
	"slug" => "stint-ultra-condensed"
    ) , array(
	"fontFamily" => "Stint Ultra Expanded",
	"name" => "Stint Ultra Expanded",
	"slug" => "stint-ultra-expanded"
    ) , array(
	"fontFamily" => "Stoke",
	"name" => "Stoke",
	"slug" => "stoke"
    ) , array(
	"fontFamily" => "Strait",
	"name" => "Strait",
	"slug" => "strait"
    ) , array(
	"fontFamily" => "Style Script",
	"name" => "Style Script",
	"slug" => "style-script"
    ) , array(
	"fontFamily" => "Stylish",
	"name" => "Stylish",
	"slug" => "stylish"
    ) , array(
	"fontFamily" => "Sue Ellen Francisco",
	"name" => "Sue Ellen Francisco",
	"slug" => "sue-ellen-francisco"
    ) , array(
	"fontFamily" => "Suez One",
	"name" => "Suez One",
	"slug" => "suez-one"
    ) , array(
	"fontFamily" => "Sulphur Point",
	"name" => "Sulphur Point",
	"slug" => "sulphur-point"
    ) , array(
	"fontFamily" => "Sumana",
	"name" => "Sumana",
	"slug" => "sumana"
    ) , array(
	"fontFamily" => "Sunflower",
	"name" => "Sunflower",
	"slug" => "sunflower"
    ) , array(
	"fontFamily" => "Sunshiney",
	"name" => "Sunshiney",
	"slug" => "sunshiney"
    ) , array(
	"fontFamily" => "Supermercado One",
	"name" => "Supermercado One",
	"slug" => "supermercado-one"
    ) , array(
	"fontFamily" => "Sura",
	"name" => "Sura",
	"slug" => "sura"
    ) , array(
	"fontFamily" => "Suranna",
	"name" => "Suranna",
	"slug" => "suranna"
    ) , array(
	"fontFamily" => "Suravaram",
	"name" => "Suravaram",
	"slug" => "suravaram"
    ) , array(
	"fontFamily" => "Suwannaphum",
	"name" => "Suwannaphum",
	"slug" => "suwannaphum"
    ) , array(
	"fontFamily" => "Swanky and Moo Moo",
	"name" => "Swanky and Moo Moo",
	"slug" => "swanky-and-moo-moo"
    ) , array(
	"fontFamily" => "Syncopate",
	"name" => "Syncopate",
	"slug" => "syncopate"
    ) , array(
	"fontFamily" => "Syne",
	"name" => "Syne",
	"slug" => "syne"
    ) , array(
	"fontFamily" => "Syne Mono",
	"name" => "Syne Mono",
	"slug" => "syne-mono"
    ) , array(
	"fontFamily" => "Syne Tactile",
	"name" => "Syne Tactile",
	"slug" => "syne-tactile"
    ) , array(
	"fontFamily" => "Tajawal",
	"name" => "Tajawal",
	"slug" => "tajawal"
    ) , array(
	"fontFamily" => "Tangerine",
	"name" => "Tangerine",
	"slug" => "tangerine"
    ) , array(
	"fontFamily" => "Taprom",
	"name" => "Taprom",
	"slug" => "taprom"
    ) , array(
	"fontFamily" => "Tauri",
	"name" => "Tauri",
	"slug" => "tauri"
    ) , array(
	"fontFamily" => "Taviraj",
	"name" => "Taviraj",
	"slug" => "taviraj"
    ) , array(
	"fontFamily" => "Teko",
	"name" => "Teko",
	"slug" => "teko"
    ) , array(
	"fontFamily" => "Telex",
	"name" => "Telex",
	"slug" => "telex"
    ) , array(
	"fontFamily" => "Tenali Ramakrishna",
	"name" => "Tenali Ramakrishna",
	"slug" => "tenali-ramakrishna"
    ) , array(
	"fontFamily" => "Tenor Sans",
	"name" => "Tenor Sans",
	"slug" => "tenor-sans"
    ) , array(
	"fontFamily" => "Text Me One",
	"name" => "Text Me One",
	"slug" => "text-me-one"
    ) , array(
	"fontFamily" => "Texturina",
	"name" => "Texturina",
	"slug" => "texturina"
    ) , array(
	"fontFamily" => "Thasadith",
	"name" => "Thasadith",
	"slug" => "thasadith"
    ) , array(
	"fontFamily" => "The Girl Next Door",
	"name" => "The Girl Next Door",
	"slug" => "the-girl-next-door"
    ) , array(
	"fontFamily" => "The Nautigal",
	"name" => "The Nautigal",
	"slug" => "the-nautigal"
    ) , array(
	"fontFamily" => "Tienne",
	"name" => "Tienne",
	"slug" => "tienne"
    ) , array(
	"fontFamily" => "Tillana",
	"name" => "Tillana",
	"slug" => "tillana"
    ) , array(
	"fontFamily" => "Timmana",
	"name" => "Timmana",
	"slug" => "timmana"
    ) , array(
	"fontFamily" => "Tinos",
	"name" => "Tinos",
	"slug" => "tinos"
    ) , array(
	"fontFamily" => "Titan One",
	"name" => "Titan One",
	"slug" => "titan-one"
    ) , array(
	"fontFamily" => "Titillium Web",
	"name" => "Titillium Web",
	"slug" => "titillium-web"
    ) , array(
	"fontFamily" => "Tomorrow",
	"name" => "Tomorrow",
	"slug" => "tomorrow"
    ) , array(
	"fontFamily" => "Tourney",
	"name" => "Tourney",
	"slug" => "tourney"
    ) , array(
	"fontFamily" => "Trade Winds",
	"name" => "Trade Winds",
	"slug" => "trade-winds"
    ) , array(
	"fontFamily" => "Train One",
	"name" => "Train One",
	"slug" => "train-one"
    ) , array(
	"fontFamily" => "Trirong",
	"name" => "Trirong",
	"slug" => "trirong"
    ) , array(
	"fontFamily" => "Trispace",
	"name" => "Trispace",
	"slug" => "trispace"
    ) , array(
	"fontFamily" => "Trocchi",
	"name" => "Trocchi",
	"slug" => "trocchi"
    ) , array(
	"fontFamily" => "Trochut",
	"name" => "Trochut",
	"slug" => "trochut"
    ) , array(
	"fontFamily" => "Truculenta",
	"name" => "Truculenta",
	"slug" => "truculenta"
    ) , array(
	"fontFamily" => "Trykker",
	"name" => "Trykker",
	"slug" => "trykker"
    ) , array(
	"fontFamily" => "Tulpen One",
	"name" => "Tulpen One",
	"slug" => "tulpen-one"
    ) , array(
	"fontFamily" => "Turret Road",
	"name" => "Turret Road",
	"slug" => "turret-road"
    ) , array(
	"fontFamily" => "Twinkle Star",
	"name" => "Twinkle Star",
	"slug" => "twinkle-star"
    ) , array(
	"fontFamily" => "Ubuntu",
	"name" => "Ubuntu",
	"slug" => "ubuntu"
    ) , array(
	"fontFamily" => "Ubuntu Condensed",
	"name" => "Ubuntu Condensed",
	"slug" => "ubuntu-condensed"
    ) , array(
	"fontFamily" => "Ubuntu Mono",
	"name" => "Ubuntu Mono",
	"slug" => "ubuntu-mono"
    ) , array(
	"fontFamily" => "Uchen",
	"name" => "Uchen",
	"slug" => "uchen"
    ) , array(
	"fontFamily" => "Ultra",
	"name" => "Ultra",
	"slug" => "ultra"
    ) , array(
	"fontFamily" => "Uncial Antiqua",
	"name" => "Uncial Antiqua",
	"slug" => "uncial-antiqua"
    ) , array(
	"fontFamily" => "Underdog",
	"name" => "Underdog",
	"slug" => "underdog"
    ) , array(
	"fontFamily" => "Unica One",
	"name" => "Unica One",
	"slug" => "unica-one"
    ) , array(
	"fontFamily" => "UnifrakturCook",
	"name" => "UnifrakturCook",
	"slug" => "unifrakturcook"
    ) , array(
	"fontFamily" => "UnifrakturMaguntia",
	"name" => "UnifrakturMaguntia",
	"slug" => "unifrakturmaguntia"
    ) , array(
	"fontFamily" => "Unkempt",
	"name" => "Unkempt",
	"slug" => "unkempt"
    ) , array(
	"fontFamily" => "Unlock",
	"name" => "Unlock",
	"slug" => "unlock"
    ) , array(
	"fontFamily" => "Unna",
	"name" => "Unna",
	"slug" => "unna"
    ) , array(
	"fontFamily" => "Urbanist",
	"name" => "Urbanist",
	"slug" => "urbanist"
    ) , array(
	"fontFamily" => "VT323",
	"name" => "VT323",
	"slug" => "vt323"
    ) , array(
	"fontFamily" => "Vampiro One",
	"name" => "Vampiro One",
	"slug" => "vampiro-one"
    ) , array(
	"fontFamily" => "Varela",
	"name" => "Varela",
	"slug" => "varela"
    ) , array(
	"fontFamily" => "Varela Round",
	"name" => "Varela Round",
	"slug" => "varela-round"
    ) , array(
	"fontFamily" => "Varta",
	"name" => "Varta",
	"slug" => "varta"
    ) , array(
	"fontFamily" => "Vast Shadow",
	"name" => "Vast Shadow",
	"slug" => "vast-shadow"
    ) , array(
	"fontFamily" => "Vesper Libre",
	"name" => "Vesper Libre",
	"slug" => "vesper-libre"
    ) , array(
	"fontFamily" => "Viaoda Libre",
	"name" => "Viaoda Libre",
	"slug" => "viaoda-libre"
    ) , array(
	"fontFamily" => "Vibes",
	"name" => "Vibes",
	"slug" => "vibes"
    ) , array(
	"fontFamily" => "Vibur",
	"name" => "Vibur",
	"slug" => "vibur"
    ) , array(
	"fontFamily" => "Vidaloka",
	"name" => "Vidaloka",
	"slug" => "vidaloka"
    ) , array(
	"fontFamily" => "Viga",
	"name" => "Viga",
	"slug" => "viga"
    ) , array(
	"fontFamily" => "Voces",
	"name" => "Voces",
	"slug" => "voces"
    ) , array(
	"fontFamily" => "Volkhov",
	"name" => "Volkhov",
	"slug" => "volkhov"
    ) , array(
	"fontFamily" => "Vollkorn",
	"name" => "Vollkorn",
	"slug" => "vollkorn"
    ) , array(
	"fontFamily" => "Vollkorn SC",
	"name" => "Vollkorn SC",
	"slug" => "vollkorn-sc"
    ) , array(
	"fontFamily" => "Voltaire",
	"name" => "Voltaire",
	"slug" => "voltaire"
    ) , array(
	"fontFamily" => "Vujahday Script",
	"name" => "Vujahday Script",
	"slug" => "vujahday-script"
    ) , array(
	"fontFamily" => "Waiting for the Sunrise",
	"name" => "Waiting for the Sunrise",
	"slug" => "waiting-for-the-sunrise"
    ) , array(
	"fontFamily" => "Wallpoet",
	"name" => "Wallpoet",
	"slug" => "wallpoet"
    ) , array(
	"fontFamily" => "Walter Turncoat",
	"name" => "Walter Turncoat",
	"slug" => "walter-turncoat"
    ) , array(
	"fontFamily" => "Warnes",
	"name" => "Warnes",
	"slug" => "warnes"
    ) , array(
	"fontFamily" => "Waterfall",
	"name" => "Waterfall",
	"slug" => "waterfall"
    ) , array(
	"fontFamily" => "Wellfleet",
	"name" => "Wellfleet",
	"slug" => "wellfleet"
    ) , array(
	"fontFamily" => "Wendy One",
	"name" => "Wendy One",
	"slug" => "wendy-one"
    ) , array(
	"fontFamily" => "WindSong",
	"name" => "WindSong",
	"slug" => "windsong"
    ) , array(
	"fontFamily" => "Wire One",
	"name" => "Wire One",
	"slug" => "wire-one"
    ) , array(
	"fontFamily" => "Work Sans",
	"name" => "Work Sans",
	"slug" => "work-sans"
    ) , array(
	"fontFamily" => "Xanh Mono",
	"name" => "Xanh Mono",
	"slug" => "xanh-mono"
    ) , array(
	"fontFamily" => "Yaldevi",
	"name" => "Yaldevi",
	"slug" => "yaldevi"
    ) , array(
	"fontFamily" => "Yanone Kaffeesatz",
	"name" => "Yanone Kaffeesatz",
	"slug" => "yanone-kaffeesatz"
    ) , array(
	"fontFamily" => "Yantramanav",
	"name" => "Yantramanav",
	"slug" => "yantramanav"
    ) , array(
	"fontFamily" => "Yatra One",
	"name" => "Yatra One",
	"slug" => "yatra-one"
    ) , array(
	"fontFamily" => "Yellowtail",
	"name" => "Yellowtail",
	"slug" => "yellowtail"
    ) , array(
	"fontFamily" => "Yeon Sung",
	"name" => "Yeon Sung",
	"slug" => "yeon-sung"
    ) , array(
	"fontFamily" => "Yeseva One",
	"name" => "Yeseva One",
	"slug" => "yeseva-one"
    ) , array(
	"fontFamily" => "Yesteryear",
	"name" => "Yesteryear",
	"slug" => "yesteryear"
    ) , array(
	"fontFamily" => "Yomogi",
	"name" => "Yomogi",
	"slug" => "yomogi"
    ) , array(
	"fontFamily" => "Yrsa",
	"name" => "Yrsa",
	"slug" => "yrsa"
    ) , array(
	"fontFamily" => "Yuji Boku",
	"name" => "Yuji Boku",
	"slug" => "yuji-boku"
    ) , array(
	"fontFamily" => "Yuji Hentaigana Akari",
	"name" => "Yuji Hentaigana Akari",
	"slug" => "yuji-hentaigana-akari"
    ) , array(
	"fontFamily" => "Yuji Hentaigana Akebono",
	"name" => "Yuji Hentaigana Akebono",
	"slug" => "yuji-hentaigana-akebono"
    ) , array(
	"fontFamily" => "Yuji Mai",
	"name" => "Yuji Mai",
	"slug" => "yuji-mai"
    ) , array(
	"fontFamily" => "Yuji Syuku",
	"name" => "Yuji Syuku",
	"slug" => "yuji-syuku"
    ) , array(
	"fontFamily" => "Yusei Magic",
	"name" => "Yusei Magic",
	"slug" => "yusei-magic"
    ) , array(
	"fontFamily" => "ZCOOL KuaiLe",
	"name" => "ZCOOL KuaiLe",
	"slug" => "zcool-kuaile"
    ) , array(
	"fontFamily" => "ZCOOL QingKe HuangYou",
	"name" => "ZCOOL QingKe HuangYou",
	"slug" => "zcool-qingke-huangyou"
    ) , array(
	"fontFamily" => "ZCOOL XiaoWei",
	"name" => "ZCOOL XiaoWei",
	"slug" => "zcool-xiaowei"
    ) , array(
	"fontFamily" => "Zen Antique",
	"name" => "Zen Antique",
	"slug" => "zen-antique"
    ) , array(
	"fontFamily" => "Zen Antique Soft",
	"name" => "Zen Antique Soft",
	"slug" => "zen-antique-soft"
    ) , array(
	"fontFamily" => "Zen Dots",
	"name" => "Zen Dots",
	"slug" => "zen-dots"
    ) , array(
	"fontFamily" => "Zen Kaku Gothic Antique",
	"name" => "Zen Kaku Gothic Antique",
	"slug" => "zen-kaku-gothic-antique"
    ) , array(
	"fontFamily" => "Zen Kaku Gothic New",
	"name" => "Zen Kaku Gothic New",
	"slug" => "zen-kaku-gothic-new"
    ) , array(
	"fontFamily" => "Zen Kurenaido",
	"name" => "Zen Kurenaido",
	"slug" => "zen-kurenaido"
    ) , array(
	"fontFamily" => "Zen Loop",
	"name" => "Zen Loop",
	"slug" => "zen-loop"
    ) , array(
	"fontFamily" => "Zen Maru Gothic",
	"name" => "Zen Maru Gothic",
	"slug" => "zen-maru-gothic"
    ) , array(
	"fontFamily" => "Zen Old Mincho",
	"name" => "Zen Old Mincho",
	"slug" => "zen-old-mincho"
    ) , array(
	"fontFamily" => "Zen Tokyo Zoo",
	"name" => "Zen Tokyo Zoo",
	"slug" => "zen-tokyo-zoo"
    ) , array(
	"fontFamily" => "Zeyada",
	"name" => "Zeyada",
	"slug" => "zeyada"
    ) , array(
	"fontFamily" => "Zhi Mang Xing",
	"name" => "Zhi Mang Xing",
	"slug" => "zhi-mang-xing"
    ) , array(
	"fontFamily" => "Zilla Slab",
	"name" => "Zilla Slab",
	"slug" => "zilla-slab"
    ) , array(
	"fontFamily" => "Zilla Slab Highlight",
	"name" => "Zilla Slab Highlight",
	"slug" => "zilla-slab-highlight"
    ),
	);
	return $font_families;
}

function gutenify_get_global_style_fonts( array $arr ) {
	$result = array();
	if ( ! empty( $arr ) ) {
		foreach ( $arr as $key => $style ) {
			if ( 'fontFamily' === $key ) {
				$result[] = $style;
			}
			if ( is_array( $style ) ) {
				$result = array_merge( $result, gutenify_get_global_style_fonts( $style ) );
			}
		}
	}
	return $result;
}

/**
 * Add Google webfonts
 *
 * @return $fonts_url
 */
function gutenify_fonts_url() {
	$global_styles          = wp_get_global_styles();
	$font_families          = gutenify_font_families();
	$selected_font_families = array();

	$global_style_fonts = gutenify_get_global_style_fonts( $global_styles );
	$global_fonts       = array();
	if ( ! empty( $global_style_fonts ) ) {
		foreach ( $global_style_fonts as $font ) {
			$font           = str_replace( ')', '', $font );
			$global_fonts[] = str_replace( 'var(--wp--preset--font-family--', '', $font );
		}
	}

	$gutenify_site_options = get_option( 'gutenify_site_options' );
	if ( ! empty( $font_families ) ) {
		foreach ( $font_families as $family ) {
			if ( ! empty( $gutenify_site_options['styles']['typography']['fontFamilySlug'] ) && $gutenify_site_options['styles']['typography']['fontFamilySlug'] === $family['slug'] ) {
				$selected_font_families[] = 'family=' . $family['name'];
			}
			if ( ! empty( $gutenify_site_options['styles']['elements']['headings']['typography']['fontFamilySlug'] ) && $gutenify_site_options['styles']['elements']['headings']['typography']['fontFamilySlug'] === $family['slug'] ) {
				$selected_font_families[] = 'family=' . $family['name'];
			}
			if ( in_array( $family['slug'], $global_fonts ) ) {
				$selected_font_families[] = 'family=' . $family['name'];
			}
		}
	}

	if ( empty( $selected_font_families ) ) {
		return '';
	}

	foreach ( $selected_font_families as &$font ) {
		$_selected_font_families[] = $font . ':ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900';
	}

	$google_font_url = 'https://fonts.googleapis.com/css2?' . implode( '&', array_unique( $_selected_font_families ) ) . '&display=swap' ;

	if ( ! class_exists( 'WPTT_WebFont_Loader' ) ) {
		// Load Google fonts from Local.
		require_once 'lib/wptt-webfont-loader.php';
	}

	return esc_url( wptt_get_webfont_url( $google_font_url ) );

	// Make a single request for the theme or user fonts.
	// return esc_url_raw( 'https://fonts.googleapis.com/css2?' . implode( '&', array_unique( $_selected_font_families ) ) . '&display=swap' );
}
