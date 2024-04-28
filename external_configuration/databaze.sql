-- Table: public.goods

-- DROP TABLE IF EXISTS public.goods;

CREATE TABLE IF NOT EXISTS public.goods
(
    id integer NOT NULL GENERATED ALWAYS AS IDENTITY ( INCREMENT 1 START 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1 ),
    name character varying(100) COLLATE pg_catalog."default" NOT NULL,
    short_description character varying(255) COLLATE pg_catalog."default" NOT NULL,
    description text COLLATE pg_catalog."default" NOT NULL,
    price_doge numeric(15,0) NOT NULL,
    CONSTRAINT goods_pkey PRIMARY KEY (id)
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS public.goods
    OWNER to postgres;

-- Table: public.order

-- DROP TABLE IF EXISTS public."order";

CREATE TABLE IF NOT EXISTS public."order"
(
    id integer NOT NULL GENERATED ALWAYS AS IDENTITY ( INCREMENT 1 START 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1 ),
    addressee_name character varying COLLATE pg_catalog."default" NOT NULL,
    address character varying COLLATE pg_catalog."default" NOT NULL,
    city character varying COLLATE pg_catalog."default" NOT NULL,
    postcode integer NOT NULL,
    email character varying COLLATE pg_catalog."default" NOT NULL,
    phone character varying COLLATE pg_catalog."default" NOT NULL,
    payment_type integer NOT NULL,
    shipping_type integer NOT NULL,
    price integer NOT NULL,
    status integer NOT NULL,
    ordered timestamp with time zone NOT NULL,
    CONSTRAINT order_pkey PRIMARY KEY (id)
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS public."order"
    OWNER to postgres;

-- Table: public.order_item

-- DROP TABLE IF EXISTS public.order_item;

CREATE TABLE IF NOT EXISTS public.order_item
(
    goods_id integer NOT NULL,
    order_id integer NOT NULL,
    name character varying COLLATE pg_catalog."default" NOT NULL,
    price numeric NOT NULL,
    CONSTRAINT order_item_pkey PRIMARY KEY (goods_id, order_id),
    CONSTRAINT goods_id_fk FOREIGN KEY (goods_id)
        REFERENCES public.goods (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
    CONSTRAINT order_id_fk FOREIGN KEY (order_id)
        REFERENCES public."order" (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS public.order_item
    OWNER to postgres;


INSERT INTO public.goods ( name, short_description, description, price_doge) VALUES
(	'ČEZ',	'ČEZ, a. s. (České energetické závody) je největší výrobce elektřiny v České republice a mateřská společnost Skupiny ČEZ, která sdružuje další desítky společností.',	'ČEZ, a. s. (České energetické závody) je největší výrobce elektřiny v České republice a mateřská společnost Skupiny ČEZ, která sdružuje další desítky společností a působí zejména na trzích střední Evropy. Skupina ČEZ se zabývá především výrobou, distribucí a prodejem energií koncovým zákazníkům. Kromě energií nabízí ale i další služby, jako například mobilní volání. V roce 2021 byl ČEZ druhou největší českou firmou podle tržeb se zhruba 28 tisíci zaměstnanců je druhým největším zaměstnavatelem v ČR.',	'99788270'),
(	'O2 Czech Republic',	'O2 Czech Republic je firma patřící do investiční skupiny PPF. Je poskytovatelem kompletního spektra ICT služeb.',	'O2 Czech Republic je firma patřící do investiční skupiny PPF. Je poskytovatelem kompletního spektra ICT služeb.\nV roce 2009 byla Telefónica O2 Czech Republic sedmou největší českou firmou dle výše tržeb (59,889 mld.) a třetí největší českou firmou dle výše zisku (14,877 mld.). Na konci září roku 2009 společnost zaměstnávala 7 716 zaměstnanců (meziroční pokles o 13,7 %). V září 2010 měla firma 4 856 000 mobilních zákazníků a 1 686 000 pevných linek.',	'67146902'),
(	'CETIN',	'CETIN a. s. (dříve Česká telekomunikační infrastruktura a. s.) je česká telekomunikační společnost patřící do investiční skupiny PPF.',	'CETIN a. s. (dříve Česká telekomunikační infrastruktura a. s.) je česká telekomunikační společnost patřící do investiční skupiny PPF. Provozuje síť, která v Česku pokrývá většinu populace. Je součástí CETIN Group, která kromě Česka spravuje telekomunikační sítě v Bulharsku, Maďarsku a Srbsku.',	57903681),
(	'Kofola ČeskoSlovensko',	'Kofola ČeskoSlovensko a.s. je česká akciová společnost vyrábějící nealkoholické nápoje, jejíž akcie se obchodují na Burze cenných papírů Praha a RM-SYSTÉMu.',	'Kofola ČeskoSlovensko a.s. je česká akciová společnost vyrábějící nealkoholické nápoje, jejíž akcie se obchodují na Burze cenných papírů Praha a RM-SYSTÉMu.\nJe mateřskou společností nápojářské skupiny Kofola (dříve Santa Nápoje, původně SP Vrachos), která působí také ve Slovinsku, Chorvatsku, Rusku, Rakousku a v Maďarsku. Skupina vyrábí v osmi závodech, např. v Krnově, v Rajecké Lesné nebo Radenci.\nV roce 2015 byla 62. největší českou firmou, s tržbami přes 7 miliard korun ročně.\nV posledních letech se pod značkou Ugo zaměřuje také na výrobu zdravých potravin.',	'35568901'),
(	'Agrofert',	'AGROFERT, a.s., je český holdingový konglomerát operující především v odvětvích zemědělství, potravinářství, chemického průmyslu a médií, pod který patří více než 250 dceřiných společností.',	'AGROFERT, a.s., je český holdingový konglomerát operující především v odvětvích zemědělství, potravinářství, chemického průmyslu a médií, pod který patří více než 250 dceřiných společností. Většina z nich je v přímém vlastnictví centrály AGROFERT, a.s., menší část portfolia tvoří společnosti, v nichž má mateřská společnost podstatný vliv.\nSpolečnosti koncernu Agrofert působí zejména v regionu střední Evropy: v Česku, na Slovensku, v Německu a v Maďarsku. Dále má společnost obchodní zastoupení v dalších 18 zemích světa na čtyřech kontinentech. Její konsolidované tržby dosáhly v roce 2012 téměř 132,5 miliard Kč. V roce 2018 činil celkový obrat společnosti 157,5 miliardy Kč. Koncern Agrofert tak patří mezi největší firmy v České republice. Zemědělské společnosti koncernu se v České republice starají o více než 100 tisíc hektarů zemědělské půdy (naprostá většina půdy je v nájmu; jde o 1,26 % území České republiky nebo 2,84 % zemědělské půdy v ČR). Společnost do ledna 2014 řídil a do roku 2017 vlastnil Andrej Babiš, který ji kvůli novele zákona o střetu zájmů převedl na dva svěřenské fondy AB private trust I a AB private trust II. V červnu 2021 Agrofert uváděl Andreje Babiše jako hlavního koncového příjemce příjmů ze svého podnikání. K roku 2017 koncern zaměstnával 33 tisíc zaměstnanců, z nich 22 tisíc v ČR.',	'10356890');
