--
-- PostgreSQL database dump
--

-- Dumped from database version 9.6.11
-- Dumped by pg_dump version 9.6.11

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: topology; Type: SCHEMA; Schema: -; Owner: postgres
--

CREATE SCHEMA topology;


ALTER SCHEMA topology OWNER TO postgres;

--
-- Name: SCHEMA topology; Type: COMMENT; Schema: -; Owner: postgres
--

COMMENT ON SCHEMA topology IS 'PostGIS Topology schema';


--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


--
-- Name: hstore; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS hstore WITH SCHEMA public;


--
-- Name: EXTENSION hstore; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION hstore IS 'data type for storing sets of (key, value) pairs';


--
-- Name: postgis; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS postgis WITH SCHEMA public;


--
-- Name: EXTENSION postgis; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION postgis IS 'PostGIS geometry, geography, and raster spatial types and functions';


--
-- Name: postgis_topology; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS postgis_topology WITH SCHEMA topology;


--
-- Name: EXTENSION postgis_topology; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION postgis_topology IS 'PostGIS topology spatial types and functions';


--
-- Name: set_geometry_properties(); Type: FUNCTION; Schema: public; Owner: smartcity
--

CREATE FUNCTION public.set_geometry_properties() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
                BEGIN
                    NEW.length := ST_Length(NEW.geometry);
                    NEW.area := ST_Area(NEW.geometry);
                    NEW.perimeter := ST_Perimeter(NEW.geometry);
                    RETURN NEW;
                END;           
            $$;


ALTER FUNCTION public.set_geometry_properties() OWNER TO smartcity;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: address; Type: TABLE; Schema: public; Owner: smartcity
--

CREATE TABLE public.address (
    id integer NOT NULL,
    index integer NOT NULL,
    region character varying(255) NOT NULL,
    city character varying(255) NOT NULL,
    street character varying(255) NOT NULL,
    build character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.address OWNER TO smartcity;

--
-- Name: address_id_seq; Type: SEQUENCE; Schema: public; Owner: smartcity
--

CREATE SEQUENCE public.address_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.address_id_seq OWNER TO smartcity;

--
-- Name: address_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: smartcity
--

ALTER SEQUENCE public.address_id_seq OWNED BY public.address.id;


--
-- Name: constructed_2; Type: TABLE; Schema: public; Owner: smartcity
--

CREATE TABLE public.constructed_2 (
    feeding_point integer,
    element_id integer NOT NULL,
    area character varying(255),
    street character varying(255) DEFAULT 'Не указано'::character varying,
    building character varying(255) DEFAULT 'Не указано'::character varying,
    type character varying(255),
    model character varying(255) DEFAULT 'Не указано'::character varying,
    height character varying(255) DEFAULT 'Не указано'::character varying,
    property_rights character varying(255),
    ownership character varying(255),
    organization character varying(255),
    inventory character varying(255) DEFAULT 'Не указано'::character varying,
    carrying_amount character varying(255) DEFAULT 'Не указано'::character varying,
    residual_amount character varying(255) DEFAULT 'Не указано'::character varying,
    date date DEFAULT '1970-01-01'::date,
    life_time integer DEFAULT 0,
    age integer DEFAULT 0,
    "date-last-1" date DEFAULT '1970-01-01'::date,
    "date-next-1" date DEFAULT '1970-01-01'::date,
    "date-last-2" date DEFAULT '1970-01-01'::date,
    "date-next-2" date DEFAULT '1970-01-01'::date,
    "date-last-3" date DEFAULT '1970-01-01'::date,
    "date-next-3" date DEFAULT '1970-01-01'::date,
    "date-last" date DEFAULT '1970-01-01'::date,
    "date-next" date DEFAULT '1970-01-01'::date,
    opora integer DEFAULT 0
);


ALTER TABLE public.constructed_2 OWNER TO smartcity;

--
-- Name: constructed_3; Type: TABLE; Schema: public; Owner: smartcity
--

CREATE TABLE public.constructed_3 (
    opora integer DEFAULT 0,
    element_id integer NOT NULL,
    illuminator_type character varying(255),
    lamp_type character varying(255),
    lamp_power character varying(255) DEFAULT 'Не указано'::character varying,
    loss character varying(255) DEFAULT 'Не указано'::character varying,
    burning_schedule text DEFAULT 'Не указано'::text,
    dimming_schedule text DEFAULT 'Не указано'::text,
    property_rights character varying(255),
    ownership character varying(255),
    operating_organization character varying(255),
    inventory_number character varying(255) DEFAULT 'Не указано'::character varying,
    carrying_amount character varying(255) DEFAULT 'Не указано'::character varying,
    residual_value character varying(255) DEFAULT 'Не указано'::character varying,
    date date DEFAULT '1970-01-01'::date,
    service_life integer DEFAULT 0,
    age integer DEFAULT 0,
    installation_date date DEFAULT '1970-01-01'::date,
    date_last_1 date DEFAULT '1970-01-01'::date,
    date_next_1 date DEFAULT '1970-01-01'::date,
    date_last_2 date DEFAULT '1970-01-01'::date,
    date_next_2 date DEFAULT '1970-01-01'::date,
    date_last_3 date DEFAULT '1970-01-01'::date,
    date_next_3 date DEFAULT '1970-01-01'::date,
    date_last date DEFAULT '1970-01-01'::date,
    date_next date DEFAULT '1970-01-01'::date,
    bracket_type character varying(255),
    rice integer DEFAULT 0,
    angle integer DEFAULT 0,
    diameter integer DEFAULT 0,
    height integer DEFAULT 0,
    bracket_property_rights character varying(255),
    bracket_ownership character varying(255),
    bracket_operating_organization character varying(255),
    bracket_inventory_number character varying(255) DEFAULT 'Не указано'::character varying,
    bracket_carrying_amount character varying(255) DEFAULT 'Не указано'::character varying,
    bracket_residual_value character varying(255) DEFAULT 'Не указано'::character varying,
    bracket_date date DEFAULT '1970-01-01'::date,
    bracket_service_life integer DEFAULT 0,
    bracket_age integer DEFAULT 0,
    bracket_date_last_1 date DEFAULT '1970-01-01'::date,
    bracket_date_next_1 date DEFAULT '1970-01-01'::date,
    bracket_date_last_2 date DEFAULT '1970-01-01'::date,
    bracket_date_next_2 date DEFAULT '1970-01-01'::date,
    bracket_date_last_3 date DEFAULT '1970-01-01'::date,
    bracket_date_next_3 date DEFAULT '1970-01-01'::date,
    bracket_date_last date DEFAULT '1970-01-01'::date,
    bracket_date_next date DEFAULT '1970-01-01'::date
);


ALTER TABLE public.constructed_3 OWNER TO smartcity;

--
-- Name: constructed_6; Type: TABLE; Schema: public; Owner: smartcity
--

CREATE TABLE public.constructed_6 (
    number character varying(255) DEFAULT 'Не указано'::character varying NOT NULL,
    element_id integer NOT NULL,
    region character varying(255) NOT NULL,
    cascade character varying(255) DEFAULT 'Не указано'::character varying,
    place character varying(255) DEFAULT 'Не указано'::character varying,
    tablet_number character varying(255) DEFAULT 'Не указано'::character varying,
    title character varying(255) DEFAULT 'Не указано'::character varying,
    line_count integer DEFAULT 0,
    device_type character varying(255) DEFAULT 'Не указано'::character varying,
    device_date date DEFAULT '1970-01-01'::date,
    switch_type character varying(255) DEFAULT 'Не указано'::character varying,
    switch_date date DEFAULT '1970-01-01'::date,
    switch_voltage integer DEFAULT 0,
    telemechanical_type character varying(255) DEFAULT 'Не указано'::character varying,
    telemechanical_number character varying(255) DEFAULT 'Не указано'::character varying,
    telemechanical_date date DEFAULT '1970-01-01'::date,
    machine_type character varying(255) DEFAULT 'Не указано'::character varying,
    machine_year integer DEFAULT 0,
    machine_date date DEFAULT '1970-01-01'::date,
    supply_line character varying(255) DEFAULT 'Не указано'::character varying,
    operating_voltage integer DEFAULT 0,
    project character varying(255) DEFAULT 'Не указано'::character varying,
    tdp integer DEFAULT 0,
    parent_number character varying(255) DEFAULT 'Не указано'::character varying,
    year integer DEFAULT 0,
    year_of_commissioning integer DEFAULT 0,
    line_type character varying(255),
    line_mark character varying(255),
    line_distance integer DEFAULT 0,
    line_voltage integer DEFAULT 0,
    line_date date,
    price integer DEFAULT 0,
    relay_type character varying(255),
    relay_number integer DEFAULT 0,
    relay_date date,
    tp integer DEFAULT 0,
    kind character varying(255),
    kind_type character varying(255),
    property_rights character varying(255),
    ownership character varying(255),
    organization character varying(255),
    street character varying(255) DEFAULT 'Не указано'::character varying,
    building character varying(255) DEFAULT 'Не указано'::character varying,
    inventory character varying(255) DEFAULT 'Не указано'::character varying,
    carrying_amount character varying(255) DEFAULT 'Не указано'::character varying,
    residual_amount character varying(255) DEFAULT 'Не указано'::character varying,
    date date DEFAULT '1970-01-01'::date,
    life_time integer DEFAULT 0,
    age integer DEFAULT 0,
    date_last_1 date DEFAULT '1970-01-01'::date,
    date_next_1 date DEFAULT '1970-01-01'::date,
    date_last_2 date DEFAULT '1970-01-01'::date,
    date_next_2 date DEFAULT '1970-01-01'::date,
    date_last_3 date DEFAULT '1970-01-01'::date,
    date_next_3 date DEFAULT '1970-01-01'::date,
    date_last date DEFAULT '1970-01-01'::date,
    date_next date DEFAULT '1970-01-01'::date,
    counter_brand character varying(255) DEFAULT 'Не указано'::character varying,
    counter_date date DEFAULT '1970-01-01'::date,
    counter_life_time integer DEFAULT 0,
    counter_age integer DEFAULT 0,
    counter_date_last date DEFAULT '1970-01-01'::date,
    counter_date_next date DEFAULT '1970-01-01'::date,
    amperage_date_last date DEFAULT '1970-01-01'::date,
    amperage_date_next date DEFAULT '1970-01-01'::date,
    meter_1 integer DEFAULT 0,
    meter_2 integer DEFAULT 0,
    meter_3 integer DEFAULT 0,
    deviasion integer DEFAULT 0
);


ALTER TABLE public.constructed_6 OWNER TO smartcity;

--
-- Name: constructor_metadata; Type: TABLE; Schema: public; Owner: smartcity
--

CREATE TABLE public.constructor_metadata (
    id integer NOT NULL,
    table_identifier character varying(255) NOT NULL,
    title character varying(255) NOT NULL,
    tech_title character varying(255) NOT NULL,
    required boolean NOT NULL,
    type character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    enums json,
    "group" character varying(255),
    is_deleted boolean DEFAULT false NOT NULL,
    options json
);


ALTER TABLE public.constructor_metadata OWNER TO smartcity;

--
-- Name: constructor_metadata_id_seq; Type: SEQUENCE; Schema: public; Owner: smartcity
--

CREATE SEQUENCE public.constructor_metadata_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.constructor_metadata_id_seq OWNER TO smartcity;

--
-- Name: constructor_metadata_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: smartcity
--

ALTER SEQUENCE public.constructor_metadata_id_seq OWNED BY public.constructor_metadata.id;


--
-- Name: contractors; Type: TABLE; Schema: public; Owner: smartcity
--

CREATE TABLE public.contractors (
    id integer NOT NULL,
    name character varying(255) NOT NULL,
    full_name character varying(255) NOT NULL,
    inn character varying(255) NOT NULL,
    kpp character varying(255),
    address_id integer,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.contractors OWNER TO smartcity;

--
-- Name: contractors_id_seq; Type: SEQUENCE; Schema: public; Owner: smartcity
--

CREATE SEQUENCE public.contractors_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.contractors_id_seq OWNER TO smartcity;

--
-- Name: contractors_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: smartcity
--

ALTER SEQUENCE public.contractors_id_seq OWNED BY public.contractors.id;


--
-- Name: geo_elements; Type: TABLE; Schema: public; Owner: smartcity
--

CREATE TABLE public.geo_elements (
    id integer NOT NULL,
    layer_id integer NOT NULL,
    title character varying(255) NOT NULL,
    description text,
    address_id integer,
    geometry public.geometry,
    length double precision,
    area double precision,
    perimeter double precision,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    element_next_id integer
);


ALTER TABLE public.geo_elements OWNER TO smartcity;

--
-- Name: geo_elements_id_seq; Type: SEQUENCE; Schema: public; Owner: smartcity
--

CREATE SEQUENCE public.geo_elements_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.geo_elements_id_seq OWNER TO smartcity;

--
-- Name: geo_elements_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: smartcity
--

ALTER SEQUENCE public.geo_elements_id_seq OWNED BY public.geo_elements.id;


--
-- Name: geo_layers; Type: TABLE; Schema: public; Owner: smartcity
--

CREATE TABLE public.geo_layers (
    id integer NOT NULL,
    alias character varying(255),
    title character varying(255) NOT NULL,
    description text,
    parent_id integer,
    module_id integer NOT NULL,
    visibility boolean DEFAULT false NOT NULL,
    geometry_type character varying(255) DEFAULT 'point'::character varying NOT NULL,
    style json,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT geo_layers_geometry_type_check CHECK (((geometry_type)::text = ANY ((ARRAY['point'::character varying, 'linestring'::character varying, 'polygon'::character varying])::text[])))
);


ALTER TABLE public.geo_layers OWNER TO smartcity;

--
-- Name: geo_layers_id_seq; Type: SEQUENCE; Schema: public; Owner: smartcity
--

CREATE SEQUENCE public.geo_layers_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.geo_layers_id_seq OWNER TO smartcity;

--
-- Name: geo_layers_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: smartcity
--

ALTER SEQUENCE public.geo_layers_id_seq OWNED BY public.geo_layers.id;


--
-- Name: migrations; Type: TABLE; Schema: public; Owner: smartcity
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE public.migrations OWNER TO smartcity;

--
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: smartcity
--

CREATE SEQUENCE public.migrations_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.migrations_id_seq OWNER TO smartcity;

--
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: smartcity
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- Name: modules; Type: TABLE; Schema: public; Owner: smartcity
--

CREATE TABLE public.modules (
    id integer NOT NULL,
    title character varying(255) NOT NULL,
    description text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.modules OWNER TO smartcity;

--
-- Name: modules_id_seq; Type: SEQUENCE; Schema: public; Owner: smartcity
--

CREATE SEQUENCE public.modules_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.modules_id_seq OWNER TO smartcity;

--
-- Name: modules_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: smartcity
--

ALTER SEQUENCE public.modules_id_seq OWNED BY public.modules.id;


--
-- Name: oauth_access_tokens; Type: TABLE; Schema: public; Owner: smartcity
--

CREATE TABLE public.oauth_access_tokens (
    id character varying(100) NOT NULL,
    user_id bigint,
    client_id integer NOT NULL,
    name character varying(255),
    scopes text,
    revoked boolean NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    expires_at timestamp(0) without time zone
);


ALTER TABLE public.oauth_access_tokens OWNER TO smartcity;

--
-- Name: oauth_auth_codes; Type: TABLE; Schema: public; Owner: smartcity
--

CREATE TABLE public.oauth_auth_codes (
    id character varying(100) NOT NULL,
    user_id bigint NOT NULL,
    client_id integer NOT NULL,
    scopes text,
    revoked boolean NOT NULL,
    expires_at timestamp(0) without time zone
);


ALTER TABLE public.oauth_auth_codes OWNER TO smartcity;

--
-- Name: oauth_clients; Type: TABLE; Schema: public; Owner: smartcity
--

CREATE TABLE public.oauth_clients (
    id integer NOT NULL,
    user_id bigint,
    name character varying(255) NOT NULL,
    secret character varying(100) NOT NULL,
    redirect text NOT NULL,
    personal_access_client boolean NOT NULL,
    password_client boolean NOT NULL,
    revoked boolean NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.oauth_clients OWNER TO smartcity;

--
-- Name: oauth_clients_id_seq; Type: SEQUENCE; Schema: public; Owner: smartcity
--

CREATE SEQUENCE public.oauth_clients_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.oauth_clients_id_seq OWNER TO smartcity;

--
-- Name: oauth_clients_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: smartcity
--

ALTER SEQUENCE public.oauth_clients_id_seq OWNED BY public.oauth_clients.id;


--
-- Name: oauth_personal_access_clients; Type: TABLE; Schema: public; Owner: smartcity
--

CREATE TABLE public.oauth_personal_access_clients (
    id integer NOT NULL,
    client_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.oauth_personal_access_clients OWNER TO smartcity;

--
-- Name: oauth_personal_access_clients_id_seq; Type: SEQUENCE; Schema: public; Owner: smartcity
--

CREATE SEQUENCE public.oauth_personal_access_clients_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.oauth_personal_access_clients_id_seq OWNER TO smartcity;

--
-- Name: oauth_personal_access_clients_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: smartcity
--

ALTER SEQUENCE public.oauth_personal_access_clients_id_seq OWNED BY public.oauth_personal_access_clients.id;


--
-- Name: oauth_refresh_tokens; Type: TABLE; Schema: public; Owner: smartcity
--

CREATE TABLE public.oauth_refresh_tokens (
    id character varying(100) NOT NULL,
    access_token_id character varying(100) NOT NULL,
    revoked boolean NOT NULL,
    expires_at timestamp(0) without time zone
);


ALTER TABLE public.oauth_refresh_tokens OWNER TO smartcity;

--
-- Name: password_resets; Type: TABLE; Schema: public; Owner: smartcity
--

CREATE TABLE public.password_resets (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);


ALTER TABLE public.password_resets OWNER TO smartcity;

--
-- Name: privileges; Type: TABLE; Schema: public; Owner: smartcity
--

CREATE TABLE public.privileges (
    id integer NOT NULL,
    contractor_id integer NOT NULL,
    module_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.privileges OWNER TO smartcity;

--
-- Name: privileges_id_seq; Type: SEQUENCE; Schema: public; Owner: smartcity
--

CREATE SEQUENCE public.privileges_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.privileges_id_seq OWNER TO smartcity;

--
-- Name: privileges_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: smartcity
--

ALTER SEQUENCE public.privileges_id_seq OWNED BY public.privileges.id;


--
-- Name: users; Type: TABLE; Schema: public; Owner: smartcity
--

CREATE TABLE public.users (
    id integer NOT NULL,
    name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    email_verified_at timestamp(0) without time zone,
    password character varying(255) NOT NULL,
    contractor_id integer,
    remember_token character varying(100),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    role character varying(255) DEFAULT 'admin'::character varying NOT NULL,
    CONSTRAINT users_role_check CHECK (((role)::text = ANY ((ARRAY['admin'::character varying, 'superadmin'::character varying])::text[])))
);


ALTER TABLE public.users OWNER TO smartcity;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: smartcity
--

CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.users_id_seq OWNER TO smartcity;

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: smartcity
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- Name: address id; Type: DEFAULT; Schema: public; Owner: smartcity
--

ALTER TABLE ONLY public.address ALTER COLUMN id SET DEFAULT nextval('public.address_id_seq'::regclass);


--
-- Name: constructor_metadata id; Type: DEFAULT; Schema: public; Owner: smartcity
--

ALTER TABLE ONLY public.constructor_metadata ALTER COLUMN id SET DEFAULT nextval('public.constructor_metadata_id_seq'::regclass);


--
-- Name: contractors id; Type: DEFAULT; Schema: public; Owner: smartcity
--

ALTER TABLE ONLY public.contractors ALTER COLUMN id SET DEFAULT nextval('public.contractors_id_seq'::regclass);


--
-- Name: geo_elements id; Type: DEFAULT; Schema: public; Owner: smartcity
--

ALTER TABLE ONLY public.geo_elements ALTER COLUMN id SET DEFAULT nextval('public.geo_elements_id_seq'::regclass);


--
-- Name: geo_layers id; Type: DEFAULT; Schema: public; Owner: smartcity
--

ALTER TABLE ONLY public.geo_layers ALTER COLUMN id SET DEFAULT nextval('public.geo_layers_id_seq'::regclass);


--
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: smartcity
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- Name: modules id; Type: DEFAULT; Schema: public; Owner: smartcity
--

ALTER TABLE ONLY public.modules ALTER COLUMN id SET DEFAULT nextval('public.modules_id_seq'::regclass);


--
-- Name: oauth_clients id; Type: DEFAULT; Schema: public; Owner: smartcity
--

ALTER TABLE ONLY public.oauth_clients ALTER COLUMN id SET DEFAULT nextval('public.oauth_clients_id_seq'::regclass);


--
-- Name: oauth_personal_access_clients id; Type: DEFAULT; Schema: public; Owner: smartcity
--

ALTER TABLE ONLY public.oauth_personal_access_clients ALTER COLUMN id SET DEFAULT nextval('public.oauth_personal_access_clients_id_seq'::regclass);


--
-- Name: privileges id; Type: DEFAULT; Schema: public; Owner: smartcity
--

ALTER TABLE ONLY public.privileges ALTER COLUMN id SET DEFAULT nextval('public.privileges_id_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: smartcity
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Data for Name: address; Type: TABLE DATA; Schema: public; Owner: smartcity
--

COPY public.address (id, index, region, city, street, build, created_at, updated_at) FROM stdin;
1	414000	30	г. Астрахань			2019-09-26 19:58:56	2019-09-26 19:58:56
2	414000	30	г. Астрахань	ул. Дубровинского 52, к. 1		2019-09-26 19:59:46	2019-09-26 20:02:02
3	414000	30	Астрахань	Пушкина	58	2020-03-02 06:57:54	2020-04-27 17:29:34
\.


--
-- Name: address_id_seq; Type: SEQUENCE SET; Schema: public; Owner: smartcity
--

SELECT pg_catalog.setval('public.address_id_seq', 3, true);


--
-- Data for Name: constructed_2; Type: TABLE DATA; Schema: public; Owner: smartcity
--

COPY public.constructed_2 (feeding_point, element_id, area, street, building, type, model, height, property_rights, ownership, organization, inventory, carrying_amount, residual_amount, date, life_time, age, "date-last-1", "date-next-1", "date-last-2", "date-next-2", "date-last-3", "date-next-3", "date-last", "date-next", opora) FROM stdin;
29	30	\N	Не указано	Не указано	\N	Не указано	Не указано	\N	\N	\N	Не указано	Не указано	Не указано	1970-01-01	10	10	1970-01-01	1970-01-01	1970-01-01	1970-01-01	1970-01-01	1970-01-01	1970-01-01	1970-01-01	0
\N	32	\N	Не указано	Не указано	\N	Не указано	Не указано	\N	\N	\N	Не указано	Не указано	Не указано	1970-01-01	100	100	1970-01-01	1970-01-01	1970-01-01	1970-01-01	1970-01-01	1970-01-01	1970-01-01	1970-01-01	30
\N	31	\N	Не указано	Не указано	\N	Не указано	Не указано	\N	\N	\N	Не указано	Не указано	Не указано	1970-01-01	100	100	1970-01-01	1970-01-01	1970-01-01	1970-01-01	1970-01-01	1970-01-01	1970-01-01	1970-01-01	32
\N	28	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	31
\N	24	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	28
\N	21	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	25
\N	25	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	24
\N	22	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	23
\N	26	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	22
\N	43	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	26
\N	51	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	1970-01-01	\N
\N	53	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	1970-01-01	52
\N	52	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	1970-01-01	50
49	50	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	1970-01-01	\N
57	58	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	1970-01-01	\N
\N	59	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	1970-01-01	58
\N	23	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	30
\N	61	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	1970-01-01	\N
\.


--
-- Data for Name: constructed_3; Type: TABLE DATA; Schema: public; Owner: smartcity
--

COPY public.constructed_3 (opora, element_id, illuminator_type, lamp_type, lamp_power, loss, burning_schedule, dimming_schedule, property_rights, ownership, operating_organization, inventory_number, carrying_amount, residual_value, date, service_life, age, installation_date, date_last_1, date_next_1, date_last_2, date_next_2, date_last_3, date_next_3, date_last, date_next, bracket_type, rice, angle, diameter, height, bracket_property_rights, bracket_ownership, bracket_operating_organization, bracket_inventory_number, bracket_carrying_amount, bracket_residual_value, bracket_date, bracket_service_life, bracket_age, bracket_date_last_1, bracket_date_next_1, bracket_date_last_2, bracket_date_next_2, bracket_date_last_3, bracket_date_next_3, bracket_date_last, bracket_date_next) FROM stdin;
30	34	\N	\N	Не указано	Не указано	<p>Не указано</p>	<p>Не указано</p>	\N	\N	\N	Не указано	Не указано	Не указано	1970-01-01	10	10	1970-01-01	1970-01-01	1970-01-01	1970-01-01	1970-01-01	1970-01-01	1970-01-01	1970-01-01	1970-01-01	\N	0	0	0	0	\N	\N	\N	Не указано	Не указано	Не указано	1970-01-01	10	10	1970-01-01	1970-01-01	1970-01-01	1970-01-01	1970-01-01	1970-01-01	1970-01-01	1970-01-01
30	35	\N	\N	Не указано	Не указано	<p>Не указано</p>	<p>Не указано</p>	\N	\N	\N	Не указано	Не указано	Не указано	1970-01-01	0	0	1970-01-01	1970-01-01	1970-01-01	1970-01-01	1970-01-01	1970-01-01	1970-01-01	1970-01-01	1970-01-01	\N	0	0	0	0	\N	\N	\N	Не указано	Не указано	Не указано	1970-01-01	0	0	1970-01-01	1970-01-01	1970-01-01	1970-01-01	1970-01-01	1970-01-01	1970-01-01	1970-01-01
32	33	\N	\N	Не указано	Не указано	<p>Не указано</p>	<p>Не указано</p>	\N	\N	\N	Не указано	Не указано	Не указано	1970-01-01	0	0	1970-01-01	1970-01-01	1970-01-01	1970-01-01	1970-01-01	1970-01-01	1970-01-01	1970-01-01	1970-01-01	\N	0	0	0	0	\N	\N	\N	Не указано	Не указано	Не указано	1970-01-01	0	0	1970-01-01	1970-01-01	1970-01-01	1970-01-01	1970-01-01	1970-01-01	1970-01-01	1970-01-01
31	37	\N	\N	Не указано	Не указано	<p>Не указано</p>	<p>Не указано</p>	\N	\N	\N	Не указано	Не указано	Не указано	1970-01-01	0	0	1970-01-01	1970-01-01	1970-01-01	1970-01-01	1970-01-01	1970-01-01	1970-01-01	1970-01-01	1970-01-01	\N	0	0	0	0	\N	\N	\N	Не указано	Не указано	Не указано	1970-01-01	0	0	1970-01-01	1970-01-01	1970-01-01	1970-01-01	1970-01-01	1970-01-01	1970-01-01	1970-01-01
28	36	\N	\N	Не указано	Не указано	<p>Не указано</p>	<p>Не указано</p>	\N	\N	\N	Не указано	Не указано	Не указано	1970-01-01	0	0	1970-01-01	1970-01-01	1970-01-01	1970-01-01	1970-01-01	1970-01-01	1970-01-01	1970-01-01	1970-01-01	\N	0	0	0	0	\N	\N	\N	Не указано	Не указано	Не указано	1970-01-01	0	0	1970-01-01	1970-01-01	1970-01-01	1970-01-01	1970-01-01	1970-01-01	1970-01-01	1970-01-01
24	40	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
24	39	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
25	42	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
21	41	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
23	44	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
22	45	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
26	46	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
43	47	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
43	48	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
50	55	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
50	56	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
59	60	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
\.


--
-- Data for Name: constructed_6; Type: TABLE DATA; Schema: public; Owner: smartcity
--

COPY public.constructed_6 (number, element_id, region, cascade, place, tablet_number, title, line_count, device_type, device_date, switch_type, switch_date, switch_voltage, telemechanical_type, telemechanical_number, telemechanical_date, machine_type, machine_year, machine_date, supply_line, operating_voltage, project, tdp, parent_number, year, year_of_commissioning, line_type, line_mark, line_distance, line_voltage, line_date, price, relay_type, relay_number, relay_date, tp, kind, kind_type, property_rights, ownership, organization, street, building, inventory, carrying_amount, residual_amount, date, life_time, age, date_last_1, date_next_1, date_last_2, date_next_2, date_last_3, date_next_3, date_last, date_next, counter_brand, counter_date, counter_life_time, counter_age, counter_date_last, counter_date_next, amperage_date_last, amperage_date_next, meter_1, meter_2, meter_3, deviasion) FROM stdin;
1096	29	Трусовский	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	38	\N	\N	\N	\N	\N	Не указано	Не указано	Не указано	Не указано	Не указано	1970-01-01	0	0	1970-01-01	1970-01-01	1970-01-01	1970-01-01	1970-01-01	1970-01-01	1970-01-01	1970-01-01	Не указано	1970-01-01	0	0	1970-01-01	1970-01-01	1970-01-01	1970-01-01	0	0	0	0
2	49	Советский	1	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	54	Пункт питания	ИПРШ	ТО/собственник	\N	\N	Улица	231	12345	12345	123	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
3	57	Ленинский	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	Автоматического управления	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
\.


--
-- Data for Name: constructor_metadata; Type: TABLE DATA; Schema: public; Owner: smartcity
--

COPY public.constructor_metadata (id, table_identifier, title, tech_title, required, type, created_at, updated_at, enums, "group", is_deleted, options) FROM stdin;
167	constructed_6	Балансовая стоимость / принадлежность к балансовой стоимости сетевого комплекса	carrying_amount	f	text_field	2020-03-26 05:26:24	2020-03-26 05:38:41	null	Свойства	f	{"min":1,"max":100}
168	constructed_6	Остаточная стоимость / принадлежность к остаточной стоимости сетевого комплекса	residual_amount	f	text_field	2020-03-26 05:26:24	2020-03-26 05:38:41	null	Свойства	f	{"min":1,"max":100}
36	constructed_6	Планшет №	tablet_number	f	text_field	2020-03-05 08:13:35	2020-03-26 05:36:31	null	Дополнительные свойства	f	{"min":1,"max":100}
40	constructed_6	Месяц и год установки приборы учета	device_date	f	date_field	2020-03-05 08:19:22	2020-03-26 05:36:31	null	Дополнительные свойства	f	{"minDate":null,"maxDate":null}
35	constructed_6	Место установки	place	f	text_field	2020-03-05 08:13:35	2020-03-26 05:36:31	null	Дополнительные свойства	f	{"min":1,"max":100}
37	constructed_6	Диспетчерское наименования пункта питания	title	f	text_field	2020-03-05 08:14:21	2020-03-26 05:36:31	null	Дополнительные свойства	f	{"min":1,"max":100}
38	constructed_6	Число отходящих распределительных линий	line_count	f	number_field	2020-03-05 08:14:21	2020-03-26 05:36:31	null	Дополнительные свойства	f	{"min":1,"max":"1000"}
39	constructed_6	Тип и марка прибора учета	device_type	f	text_field	2020-03-05 08:19:22	2020-03-26 05:36:31	null	Дополнительные свойства	f	{"min":1,"max":100}
41	constructed_6	Тип и марка коммутационного аппарата	switch_type	f	text_field	2020-03-05 08:24:59	2020-03-26 05:36:31	null	Дополнительные свойства	f	{"min":1,"max":100}
42	constructed_6	Месяц и год установки коммутационного аппарата	switch_date	f	date_field	2020-03-05 08:24:59	2020-03-26 05:36:31	null	Дополнительные свойства	f	{"minDate":null,"maxDate":null}
43	constructed_6	Напряжение на катушках коммутационного аппарата, В	switch_voltage	f	number_field	2020-03-05 08:24:59	2020-03-26 05:36:31	null	Дополнительные свойства	f	{"min":1,"max":null}
45	constructed_6	Номер исполнительного пункта	telemechanical_number	f	text_field	2020-03-05 08:24:59	2020-03-26 05:36:31	null	Дополнительные свойства	f	{"min":1,"max":100}
44	constructed_6	Тип и марка телемеханического управления	telemechanical_type	f	text_field	2020-03-05 08:24:59	2020-03-26 05:36:31	null	Дополнительные свойства	f	{"min":1,"max":100}
48	constructed_6	Установка автоматического управления (год изготовления)	machine_year	f	number_field	2020-03-05 08:24:59	2020-03-26 05:36:31	null	Дополнительные свойства	f	{"min":"1900","max":"3000"}
46	constructed_6	Месяц и год установки телемеханического управления	telemechanical_date	f	date_field	2020-03-05 08:24:59	2020-03-26 05:36:31	null	Дополнительные свойства	f	{"minDate":null,"maxDate":null}
47	constructed_6	Установка автоматического управления (тип, марка)	machine_type	f	text_field	2020-03-05 08:24:59	2020-03-26 05:36:31	null	Дополнительные свойства	f	{"min":1,"max":100}
49	constructed_6	Установка автоматического управления (месяц и год установки)	machine_date	f	date_field	2020-03-05 08:24:59	2020-03-26 05:36:31	null	Дополнительные свойства	f	{"minDate":null,"maxDate":null}
51	constructed_6	Питающая линия	supply_line	f	text_field	2020-03-05 08:29:04	2020-03-26 05:36:31	null	Дополнительные свойства	f	{"min":1,"max":100}
52	constructed_6	Рабочее напряжение, В	operating_voltage	f	number_field	2020-03-05 08:29:04	2020-03-26 05:36:31	null	Дополнительные свойства	f	{"min":1,"max":"100000"}
53	constructed_6	Проект №	project	f	text_field	2020-03-05 08:29:04	2020-03-26 05:36:31	null	Дополнительные свойства	f	{"min":1,"max":100}
54	constructed_6	Расчетная мощность, кВт	tdp	f	number_field	2020-03-05 08:29:04	2020-03-26 05:36:31	null	Дополнительные свойства	f	{"min":1,"max":"100000"}
55	constructed_6	Питание от ТП №	parent_number	f	text_field	2020-03-05 08:29:04	2020-03-26 05:36:31	null	Дополнительные свойства	f	{"min":1,"max":100}
56	constructed_6	Год постройки	year	f	number_field	2020-03-05 08:29:04	2020-03-26 05:36:31	null	Дополнительные свойства	f	{"min":"1900","max":"3000"}
57	constructed_6	Год ввода в эксплуатацию	year_of_commissioning	f	number_field	2020-03-05 08:29:04	2020-03-26 05:36:31	null	Дополнительные свойства	f	{"min":"1900","max":"3000"}
61	constructed_6	Линия управления (тип)	line_type	f	one_from_many_field	2020-03-05 08:34:10	2020-03-26 05:36:31	["\\u0432\\u043e\\u0437\\u0434\\u0443\\u0448\\u043d\\u0430\\u044f","\\u043a\\u0430b\\u0435\\u043b\\u044c\\u043d\\u0430\\u044f"]	Дополнительные свойства	f	{"default":"\\u0432\\u043e\\u0437\\u0434\\u0443\\u0448\\u043d\\u0430\\u044f"}
166	constructed_6	Инвентарный номер опоры / принадлежность к инвентарному номеру сетевого комплекса	inventory	f	text_field	2020-03-26 05:26:24	2020-03-26 05:38:41	null	Свойства	f	{"min":1,"max":100}
182	constructed_6	Нормативный срок службы (лет)	counter_life_time	f	number_field	2020-03-26 05:41:28	2020-03-26 05:44:06	null	Счётчик	f	{"min":null,"max":null}
34	constructed_6	Каскад	cascade	f	text_field	2020-03-05 08:13:35	2020-04-27 19:38:12	null	Свойства	f	{"min":1,"max":100}
59	constructed_6	Промежуточное реле( число)	relay_count	f	text_field	2020-03-05 08:34:10	2020-03-05 08:38:32	null	Свойства ПП	t	{"min":1,"max":100}
60	constructed_6	Промежуточное реле (месяц и год установки)	relay_date	f	text_field	2020-03-05 08:34:10	2020-03-05 08:38:32	null	Свойства ПП	t	{"min":1,"max":100}
31	constructed_6	Номер ПП	number	t	text_field	2020-03-05 08:11:05	2020-03-26 05:13:18	null	Свойства	f	{"min":1,"max":100}
32	constructed_6	Административный район	region	t	one_from_many_field	2020-03-05 08:12:07	2020-03-26 05:13:18	["\\u041a\\u0438\\u0440\\u043e\\u0432\\u0441\\u043a\\u0438\\u0439","\\u0421\\u043e\\u0432\\u0435\\u0442\\u0441\\u043a\\u0438\\u0439","\\u041b\\u0435\\u043d\\u0438\\u043d\\u0441\\u043a\\u0438\\u0439","\\u0422\\u0440\\u0443\\u0441\\u043e\\u0432\\u0441\\u043a\\u0438\\u0439"]	Свойства	f	{"default":"\\u041a\\u0438\\u0440\\u043e\\u0432\\u0441\\u043a\\u0438\\u0439"}
66	constructed_6	Линия управления (месяц и год прокладки)	line_date	f	date_field	2020-03-05 08:34:10	2020-03-26 05:36:31	null	Дополнительные свойства	f	{"minDate":null,"maxDate":null}
67	constructed_6	Балансовая стоимость, руб	price	f	number_field	2020-03-05 08:34:10	2020-03-26 05:36:31	null	Дополнительные свойства	f	{"min":1,"max":null}
68	constructed_6	Промежуточное реле (тип, марка)	relay_type	f	text_field	2020-03-05 10:55:54	2020-03-26 05:36:31	null	Дополнительные свойства	f	{"min":1,"max":100}
69	constructed_6	Промежуточное реле (число)	relay_number	f	number_field	2020-03-05 10:55:54	2020-03-26 05:36:31	null	Дополнительные свойства	f	{"min":1,"max":null}
70	constructed_6	Промежуточное реле (месяц и год установки)	relay_date	f	date_field	2020-03-05 10:55:54	2020-03-26 05:36:31	null	Дополнительные свойства	f	{"minDate":null,"maxDate":null}
63	constructed_6	Линия управления (число фаз)	line_count	f	number_field	2020-03-05 08:34:10	2020-03-26 05:36:31	null	Дополнительные свойства	f	{"min":1,"max":100}
183	constructed_6	Наработка (лет)	counter_age	f	number_field	2020-03-26 05:41:28	2020-03-26 05:44:06	null	Счётчик	f	{"min":null,"max":null}
90	constructed_2	Дата последнего ТО-2	date-last-2	f	date_field	2020-03-16 08:15:03	2020-03-19 10:04:13	null	Дополнительные свойства	f	{"minDate":null,"maxDate":null}
120	constructed_3	Тип кранштейна	bracket_type	f	one_from_many_field	2020-03-16 10:22:35	2020-03-16 10:34:43	["\\u041a1","\\u041a2"]	Кронштейн	f	{"default":"\\u041a1"}
169	constructed_6	Дата монтажа / установки	date	f	date_field	2020-03-26 05:28:37	2020-03-26 05:32:32	null	Свойства	f	{"minDate":null,"maxDate":null}
124	constructed_3	Габариты (высота)	height	f	number_field	2020-03-16 10:34:43	2020-03-16 10:35:18	null	Кронштейн	f	{"min":null,"max":null}
126	constructed_3	Право владения / пользования	bracket_ownership	f	one_from_many_field	2020-03-16 10:34:43	2020-03-16 10:35:18	["\\u041c\\u041a\\u041f \\u0433. \\u0410\\u0441\\u0442\\u0440\\u0430\\u0445\\u0430\\u043d\\u0438 \\"\\u0413\\u043e\\u0440\\u0441\\u0432\\u0435\\u0442\\"","\\u0441\\u043e\\u0431\\u0441\\u0442\\u0432\\u0435\\u043d\\u043d\\u0438\\u043a","\\u0431\\u0435\\u0441\\u0445\\u043e\\u0437"]	Кронштейн	f	{"default":"\\u041c\\u041a\\u041f \\u0433. \\u0410\\u0441\\u0442\\u0440\\u0430\\u0445\\u0430\\u043d\\u0438 \\"\\u0413\\u043e\\u0440\\u0441\\u0432\\u0435\\u0442\\""}
127	constructed_3	Эксплуатирующая организация	bracket_operating_organization	f	one_from_many_field	2020-03-16 10:34:43	2020-03-16 10:35:18	["\\u041c\\u041a\\u041f \\u0433. \\u0410\\u0441\\u0442\\u0440\\u0430\\u0445\\u0430\\u043d\\u0438 \\"\\u0413\\u043e\\u0440\\u0441\\u0432\\u0435\\u0442\\"","\\u041c\\u041a\\u041f \\u0433. \\u0410\\u0441\\u0442\\u0440\\u0430\\u0445\\u0430\\u043d\\u0438 \\"\\u0413\\u043e\\u0440\\u0441\\u0432\\u0435\\u0442\\"","\\u041c\\u041a\\u041f \\u0433. \\u0410\\u0441\\u0442\\u0440\\u0430\\u0445\\u0430\\u043d\\u0438 \\"\\u0413\\u043e\\u0440\\u0441\\u0432\\u0435\\u0442\\""]	Кронштейн	f	{"default":"\\u041c\\u041a\\u041f \\u0433. \\u0410\\u0441\\u0442\\u0440\\u0430\\u0445\\u0430\\u043d\\u0438 \\"\\u0413\\u043e\\u0440\\u0441\\u0432\\u0435\\u0442\\""}
118	constructed_3	Дата последнего кап.ремонта	date_last	f	date_field	2020-03-16 10:09:59	2020-03-16 10:48:56	null	Светильник	f	{"minDate":null,"maxDate":null}
113	constructed_3	Дата следующего ТО-1	date_next_1	f	date_field	2020-03-16 10:09:59	2020-03-16 11:01:34	null	Светильник	f	{"minDate":null,"maxDate":null}
170	constructed_6	Нормативный срок службы (лет)	life_time	f	number_field	2020-03-26 05:28:37	2020-03-26 05:32:32	null	Свойства	f	{"min":null,"max":null}
112	constructed_3	Дата последнего ТО-1	date_last_1	f	date_field	2020-03-16 10:09:59	2020-03-16 11:01:34	null	Светильник	f	{"minDate":null,"maxDate":null}
152	constructed_3	Дата последнего ТО-3	bracket_date_last_3	f	date_field	2020-03-16 11:16:20	2020-03-16 11:40:51	null	Кронштейн	f	{"minDate":null,"maxDate":null}
153	constructed_3	Дата следующего ТО-3	bracket_date_next_3	f	date_field	2020-03-16 11:16:20	2020-03-16 11:40:51	null	Кронштейн	f	{"minDate":null,"maxDate":null}
154	constructed_3	Дата последнего кап.ремонта	bracket_date_last	f	date_field	2020-03-16 11:16:20	2020-03-16 11:40:51	null	Кронштейн	f	{"minDate":null,"maxDate":null}
91	constructed_2	Дата следующего ТО-2	date-next-2	f	date_field	2020-03-16 08:15:03	2020-03-19 10:04:13	null	Дополнительные свойства	f	{"minDate":null,"maxDate":null}
92	constructed_2	Дата последнего ТО-3	date-last-3	f	date_field	2020-03-16 08:15:03	2020-03-19 10:04:13	null	Дополнительные свойства	f	{"minDate":null,"maxDate":null}
93	constructed_2	Дата следующего ТО-3	date-next-3	f	date_field	2020-03-16 08:15:03	2020-03-19 10:04:13	null	Дополнительные свойства	f	{"minDate":null,"maxDate":null}
94	constructed_2	Дата последнего кап.ремонта	date-last	f	date_field	2020-03-16 08:15:03	2020-03-19 10:04:13	null	Дополнительные свойства	f	{"minDate":null,"maxDate":null}
95	constructed_2	Дата следующего кап.ремонта	counter_brand	f	date_field	2020-03-16 08:15:03	2020-04-25 07:36:57	null	Дополнительные свойства	t	{"minDate":null,"maxDate":null}
171	constructed_6	Наработка (лет)	age	f	number_field	2020-03-26 05:28:37	2020-03-26 05:32:32	null	Свойства	f	{"min":null,"max":null}
62	constructed_6	Линия управления (марка и сечение)	line_mark	f	text_field	2020-03-05 08:34:10	2020-03-26 05:36:31	null	Дополнительные свойства	f	{"min":1,"max":100}
64	constructed_6	Линия управления (протяженность, м)	line_distance	f	number_field	2020-03-05 08:34:10	2020-03-26 05:36:31	null	Дополнительные свойства	f	{"min":1,"max":null}
65	constructed_6	Линия управления (напряжение в конце линии, В)	line_voltage	f	number_field	2020-03-05 08:34:10	2020-03-26 05:36:31	null	Дополнительные свойства	f	{"min":1,"max":"100000"}
73	constructed_2	Район	area	f	one_from_many_field	2020-03-16 08:04:22	2020-03-16 08:06:37	["\\u0421\\u043e\\u0432\\u0435\\u0442\\u0441\\u043a\\u0438\\u0439","\\u0422\\u0440\\u0443\\u0441\\u043e\\u0432\\u0441\\u043a\\u0438\\u0439","\\u041a\\u0438\\u0440\\u043e\\u0432\\u0441\\u043a\\u0438\\u0439","\\u041b\\u0435\\u043d\\u0438\\u043d\\u0441\\u043a\\u0438\\u0439"]	Дополнительные свойства	f	{"default":"\\u0421\\u043e\\u0432\\u0435\\u0442\\u0441\\u043a\\u0438\\u0439"}
75	constructed_2	Номер дома	building	f	text_field	2020-03-16 08:04:22	2020-03-19 10:04:13	null	Дополнительные свойства	f	{"min":1,"max":100}
77	constructed_2	Марка/модель	model	f	text_field	2020-03-16 08:06:37	2020-03-19 10:04:13	null	Дополнительные свойства	f	{"min":1,"max":100}
76	constructed_2	Тип опоры	type	f	one_from_many_field	2020-03-16 08:06:37	2020-03-16 08:08:48	["\\u0436\\u0435\\u043b\\u0435\\u0437\\u043e\\u0431\\u0435\\u0442\\u043e\\u043d\\u043d\\u044b\\u0435","\\u043c\\u0435\\u0442\\u0430\\u043b\\u043b\\u0438\\u0447\\u0435\\u0441\\u043a\\u0438\\u0435","\\u0442\\u043e\\u0440\\u0448\\u0435\\u0440\\u043d\\u044b\\u0435 \\u0441\\u0442\\u043e\\u0439\\u043a\\u0438","\\u0434\\u0435\\u0440\\u0435\\u0432\\u044f\\u043d\\u043d\\u044b\\u0435","\\u0442\\u0440\\u043e\\u0441"]	Дополнительные свойства	f	{"default":"\\u0436\\u0435\\u043b\\u0435\\u0437\\u043e\\u0431\\u0435\\u0442\\u043e\\u043d\\u043d\\u044b\\u0435"}
78	constructed_2	Габариты (высота)	height	f	text_field	2020-03-16 08:06:37	2020-03-19 10:04:13	null	Дополнительные свойства	f	{"min":1,"max":100}
83	constructed_2	Балансовая стоимость / принадлежность к балансовой стоимости сетевого комплекса	carrying_amount	f	text_field	2020-03-16 08:10:25	2020-03-19 10:04:13	null	Дополнительные свойства	f	{"min":1,"max":100}
79	constructed_2	Право собственности	property_rights	f	one_from_many_field	2020-03-16 08:08:48	2020-03-16 08:10:25	["\\u0410\\u0434\\u043c\\u0438\\u043d\\u0438\\u0441\\u0442\\u0440\\u0430\\u0446\\u0438\\u044f \\u041c\\u041e \\"\\u0413\\u043e\\u0440\\u043e\\u0434 \\u0410\\u0441\\u0442\\u0440\\u0430\\u0445\\u0430\\u043d\\u044c\\"","\\u041c\\u0420\\u0421\\u041a","\\u0420\\u043e\\u0441\\u0442\\u0435\\u043b\\u0435\\u043a\\u043e\\u043c","\\u0422\\u041e\\/\\u0441\\u043e\\u0431\\u0441\\u0442\\u0432\\u0435\\u043d\\u043d\\u0438\\u043a","\\u0431\\u0435\\u0437\\u0445\\u043e\\u0437"]	Дополнительные свойства	f	{"default":"\\u0410\\u0434\\u043c\\u0438\\u043d\\u0438\\u0441\\u0442\\u0440\\u0430\\u0446\\u0438\\u044f \\u041c\\u041e \\"\\u0413\\u043e\\u0440\\u043e\\u0434 \\u0410\\u0441\\u0442\\u0440\\u0430\\u0445\\u0430\\u043d\\u044c\\""}
80	constructed_2	Право владения / пользования	ownership	f	one_from_many_field	2020-03-16 08:08:48	2020-03-16 08:10:25	["\\u041c\\u041a\\u041f \\u0433. \\u0410\\u0441\\u0442\\u0440\\u0430\\u0445\\u0430\\u043d\\u0438 \\"\\u0413\\u043e\\u0440\\u0441\\u0432\\u0435\\u0442\\"","\\u041c\\u0423 \\u0410\\u0422\\u041f","\\u041c\\u0420\\u0421\\u041a","\\u0420\\u043e\\u0441\\u0442\\u0435\\u043b\\u0435\\u043a\\u043e\\u043c","\\u0422\\u041e\\/\\u0441\\u043e\\u0431\\u0441\\u0442\\u0432\\u0435\\u043d\\u043d\\u0438\\u043a","\\u0431\\u0435\\u0437\\u0445\\u043e\\u0437"]	Дополнительные свойства	f	{"default":"\\u041c\\u041a\\u041f \\u0433. \\u0410\\u0441\\u0442\\u0440\\u0430\\u0445\\u0430\\u043d\\u0438 \\"\\u0413\\u043e\\u0440\\u0441\\u0432\\u0435\\u0442\\""}
86	constructed_2	Нормативный срок службы (лет)	life_time	f	number_field	2020-03-16 08:15:03	2020-03-19 10:04:13	null	Дополнительные свойства	f	{"min":1,"max":"500"}
87	constructed_2	Наработка (лет)	age	f	number_field	2020-03-16 08:15:03	2020-03-19 10:04:13	null	Дополнительные свойства	f	{"min":1,"max":"500"}
85	constructed_2	Дата монтажа / установки	date	f	date_field	2020-03-16 08:11:02	2020-03-16 08:15:03	null	Дополнительные свойства	f	{"minDate":null,"maxDate":null}
173	constructed_6	Дата следующего ТО-1	date_next_1	f	date_field	2020-03-26 05:32:32	2020-03-26 05:34:24	null	Свойства	f	{"minDate":null,"maxDate":null}
174	constructed_6	Дата последнего ТО-2	date_last_2	f	date_field	2020-03-26 05:32:32	2020-03-26 05:34:24	null	Свойства	f	{"minDate":null,"maxDate":null}
110	constructed_3	Наработка (лет)	age	f	number_field	2020-03-16 10:09:59	2020-03-16 11:40:51	null	Светильник	f	{"min":null,"max":null}
74	constructed_2	Улица	street	f	text_field	2020-03-16 08:04:22	2020-03-19 10:04:13	null	Дополнительные свойства	f	{"min":1,"max":100}
111	constructed_3	Дата монтажа / установки лампы	installation_date	f	date_field	2020-03-16 10:09:59	2020-03-16 10:22:35	null	Светильник	f	{"minDate":null,"maxDate":null}
116	constructed_3	Дата последнего ТО-3	date_last_3	f	date_field	2020-03-16 10:09:59	2020-03-16 11:01:34	null	Светильник	f	{"minDate":null,"maxDate":null}
117	constructed_3	Дата следующего ТО-3	date_next_3	f	date_field	2020-03-16 10:09:59	2020-03-16 11:01:34	null	Светильник	f	{"minDate":null,"maxDate":null}
122	constructed_3	Габариты (угол наклона)	angle	f	number_field	2020-03-16 10:34:43	2020-03-16 10:35:18	null	Кронштейн	f	{"min":null,"max":null}
123	constructed_3	Габариты (диаметр под светильник)	diameter	f	number_field	2020-03-16 10:34:43	2020-03-16 10:35:18	null	Кронштейн	f	{"min":null,"max":null}
114	constructed_3	Дата последнего ТО-2	date_last_2	f	date_field	2020-03-16 10:09:59	2020-03-16 11:01:34	null	Светильник	f	{"minDate":null,"maxDate":null}
119	constructed_3	Дата следующего кап.ремонта	date_next	f	date_field	2020-03-16 10:09:59	2020-03-16 10:48:56	null	Светильник	f	{"minDate":null,"maxDate":null}
115	constructed_3	Дата следующего ТО-2	date_next_2	f	date_field	2020-03-16 10:09:59	2020-03-16 11:01:34	null	Светильник	f	{"minDate":null,"maxDate":null}
109	constructed_3	Нормативный срок службы (лет)	service_life	f	number_field	2020-03-16 10:09:59	2020-03-16 11:40:51	null	Светильник	f	{"min":null,"max":null}
88	constructed_2	Дата последнего ТО-1	date-last-1	f	date_field	2020-03-16 08:15:03	2020-03-19 10:04:13	null	Дополнительные свойства	f	{"minDate":null,"maxDate":null}
89	constructed_2	Дата следующего ТО-1	date-next-1	f	date_field	2020-03-16 08:15:03	2020-03-19 10:04:13	null	Дополнительные свойства	f	{"minDate":null,"maxDate":null}
72	constructed_3	Опора	opora	f	link_field	2020-03-13 06:22:50	2020-03-16 09:52:45	null	Светильник	f	{"layers":[{"id":2,"alias":"opory","title":"\\u041e\\u043f\\u043e\\u0440\\u044b","description":null,"parent_id":null,"module_id":2,"visibility":true,"geometry_type":"point","style":{"id":1,"shape":{"points":"4","fill":{"color":"#4FBBC5"},"stroke":{"color":"#C58A6E","width":"3"},"radius":"5"},"icon":{"src":"https:\\/\\/api.city-panorama.ru\\/storage\\/images\\/layers\\/XfvRfZ2h7CjMxCBxJqA1j7KPOGh7pbE6eKvTWchh.png","anchor":[12,12],"opacity":0,"scale":1,"rotation":0},"pointType":"shape","font":{"font":"16px Calibri, sans-serif","fill":{"color":"#000000"},"stroke":{"color":"#ffffff","width":3},"textBaseline":"bottom","offsetY":-6},"list":{"hasList":"true","visibility":"true","color":"#BE6969","opacity":"50"}},"created_at":null,"updated_at":"2020-03-02 07:02:56","module":{"id":2,"title":"\\u0413\\u043e\\u0440\\u0441\\u0432\\u0435\\u0442","description":"<p>\\u041c\\u0423\\u041d\\u0418\\u0426\\u0418\\u041f\\u0410\\u041b\\u042c\\u041d\\u041e\\u0415 \\u041a\\u0410\\u0417\\u0415\\u041d\\u041d\\u041e\\u0415 \\u041f\\u0420\\u0415\\u0414\\u041f\\u0420\\u0418\\u042f\\u0422\\u0418\\u0415 \\u0413\\u041e\\u0420\\u041e\\u0414\\u0410 \\u0410\\u0421\\u0422\\u0420\\u0410\\u0425\\u0410\\u041d\\u0418 \\"\\u0413\\u041e\\u0420\\u0421\\u0412\\u0415\\u0422\\"<\\/p>","created_at":null,"updated_at":"2019-09-26 12:41:52"},"parent":null}]}
96	constructed_3	Тип светильника	illuminator_type	f	one_from_many_field	2020-03-16 10:05:32	2020-03-16 10:09:59	["\\u0441 \\u043d\\u0430\\u0442\\u0440\\u0438\\u0432\\u044b\\u043c\\u0438 \\u043b\\u0430\\u043c\\u043f\\u0430\\u043c\\u0438","\\u0441 \\u0440\\u0442\\u0443\\u0442\\u043d\\u044b\\u043c\\u0438 \\u043b\\u0430\\u043c\\u043f\\u0430\\u043c\\u0438","\\u0441 \\u043b\\u044e\\u043c\\u0438\\u043d\\u0438\\u0441\\u0446\\u0435\\u043d\\u0442\\u043d\\u044b\\u043c\\u0438 \\u043b\\u0430\\u043c\\u043f\\u0430\\u043c\\u0438","\\u0441 \\u043b\\u0430\\u043c\\u043f\\u0430\\u043c\\u0438 \\u043d\\u0430\\u043a\\u0430\\u043b\\u0438\\u0432\\u0430\\u043d\\u0438\\u044f","\\u0441\\u0432\\u0435\\u0442\\u043e\\u0434\\u0438\\u043e\\u0434\\u043d\\u044b\\u0435","\\u043c\\u0435\\u0442\\u0430\\u043b\\u043b\\u043e\\u0433\\u0430\\u043b\\u043e\\u0433\\u0435\\u043d\\u043e\\u0432\\u044b\\u0435 \\u043f\\u0440\\u043e\\u0436\\u0435\\u043a\\u0442\\u043e\\u0440\\u044b","\\u043d\\u0430\\u0442\\u0440\\u0438\\u0435\\u0432\\u044b\\u0435 \\u043f\\u0440\\u043e\\u0436\\u0435\\u043a\\u0442\\u043e\\u0440\\u044b","\\u043d\\u0430\\u043a\\u0430\\u043b\\u0438\\u0432\\u0430\\u043d\\u0438\\u044f","\\u0441\\u0432\\u0435\\u0442\\u043e\\u0434\\u0438\\u043e\\u0434\\u043d\\u044b\\u0435 PFL-20","\\u0441\\u0432\\u0435\\u0442\\u043e\\u0434\\u0438\\u043e\\u0434\\u043d\\u044b\\u0435 \\u043a\\u043e\\u043d\\u0441\\u043e\\u043b\\u0438"]	Светильник	f	{"default":"\\u0441 \\u043d\\u0430\\u0442\\u0440\\u0438\\u0432\\u044b\\u043c\\u0438 \\u043b\\u0430\\u043c\\u043f\\u0430\\u043c\\u0438"}
97	constructed_3	Тип лампы	lamp_type	f	one_from_many_field	2020-03-16 10:05:32	2020-03-16 10:09:59	["\\u0416\\u041a\\u0423-70","\\u0416\\u041a\\u0423-100","\\u0416\\u041a\\u0423-150","\\u0416\\u041a\\u0423-250","\\u0416\\u041a\\u0423-400","\\u0416\\u0421\\u0423-70","\\u0416\\u0421\\u0423-100","\\u0416\\u0421\\u0423-150","\\u0416\\u0422\\u0423-70","\\u0416\\u0422\\u0423-100","\\u0416\\u0422\\u0423-150","\\u0420\\u041a\\u0423-125","\\u0420\\u041a\\u0423-250","\\u0420\\u041a\\u0423-400","\\u0420\\u041a\\u0423-1000","\\u0420\\u0422\\u0423-125","\\u0420\\u0422\\u0423-250","\\u0420\\u0421\\u0423-125","\\u0420\\u0421\\u0423-250","\\u0420\\u0421\\u041f-250","\\u0421\\u0412\\u041e\\u0420-250","\\u0421\\u041f\\u041e\\u0420-250","\\u0421\\u041a\\u0417\\u0420-250","\\u0421\\u041a\\u0420-250","Feron","\\u041b\\u0422\\u0423-30","\\u041b\\u0422\\u0423-32","\\u041b\\u0422\\u0423-35","\\u041d\\u0422\\u0423-30","\\u041d\\u041f\\u041f-100","\\u0421\\u041f\\u041e-200","\\u0421\\u041f\\u0423-200","NBU-40 HG 150","NBU-50 HG 150","NBU-41 HG 2\\u044570","\\u041c\\u0413\\u041b-150","\\u041c\\u0413\\u041b-500","\\u0413\\u041e-400","\\u0413\\u041e-500","\\u0416\\u041e-100","\\u0416\\u041e-150","\\u0416\\u041e-250","\\u0416\\u041e-400","\\u041f\\u0417\\u0418-500","\\u041f\\u0417\\u0418-1000"]	Светильник	f	{"default":"\\u0416\\u041a\\u0423-70"}
99	constructed_3	Нормируемые потери (Ватт)	loss	f	text_field	2020-03-16 10:05:32	2020-03-16 10:44:37	null	Светильник	f	{"min":1,"max":100}
105	constructed_3	Инвентарный номер опоры / принадлежность к инвентарному номеру сетевого комплекса	inventory_number	f	text_field	2020-03-16 10:05:32	2020-03-16 10:44:37	null	Светильник	f	{"min":1,"max":100}
100	constructed_3	График горения	burning_schedule	f	long_text_field	2020-03-16 10:05:32	2020-03-16 10:09:59	null	Светильник	f	{"min":null,"max":null}
101	constructed_3	График диммирования	dimming_schedule	f	long_text_field	2020-03-16 10:05:32	2020-03-16 10:09:59	null	Светильник	f	{"min":null,"max":null}
102	constructed_3	Право собственности	property_rights	f	one_from_many_field	2020-03-16 10:05:32	2020-03-16 10:09:59	["\\u0410\\u0434\\u043c\\u0438\\u043d\\u0438\\u0441\\u0442\\u0440\\u0430\\u0446\\u0438\\u044f \\u041c\\u041e \\"\\u0413\\u043e\\u0440\\u043e\\u0434 \\u0410\\u0441\\u0442\\u0440\\u0430\\u0445\\u0430\\u043d\\u044c\\"","\\u0422\\u041e \\/ \\u0441\\u043e\\u0431\\u0441\\u0442\\u0432\\u0435\\u043d\\u043d\\u0438\\u043a","\\u0431\\u0435\\u0441\\u0445\\u043e\\u0437"]	Светильник	f	{"default":"\\u0410\\u0434\\u043c\\u0438\\u043d\\u0438\\u0441\\u0442\\u0440\\u0430\\u0446\\u0438\\u044f \\u041c\\u041e \\"\\u0413\\u043e\\u0440\\u043e\\u0434 \\u0410\\u0441\\u0442\\u0440\\u0430\\u0445\\u0430\\u043d\\u044c\\""}
103	constructed_3	Право владения / пользования	ownership	f	one_from_many_field	2020-03-16 10:05:32	2020-03-16 10:09:59	["\\u041c\\u041a\\u041f \\u0433. \\u0410\\u0441\\u0442\\u0440\\u0430\\u0445\\u0430\\u043d\\u0438 \\"\\u0413\\u043e\\u0440\\u0441\\u0432\\u0435\\u0442\\"","\\u0441\\u043e\\u0431\\u0441\\u0442\\u0432\\u0435\\u043d\\u043d\\u0438\\u043a","\\u0431\\u0435\\u0441\\u0445\\u043e\\u0437"]	Светильник	f	{"default":"\\u041c\\u041a\\u041f \\u0433. \\u0410\\u0441\\u0442\\u0440\\u0430\\u0445\\u0430\\u043d\\u0438 \\"\\u0413\\u043e\\u0440\\u0441\\u0432\\u0435\\u0442\\""}
104	constructed_3	Эксплуатирующая организация	operating_organization	f	one_from_many_field	2020-03-16 10:05:32	2020-03-16 10:09:59	["\\u041c\\u041a\\u041f \\u0433. \\u0410\\u0441\\u0442\\u0440\\u0430\\u0445\\u0430\\u043d\\u0438 \\"\\u0413\\u043e\\u0440\\u0441\\u0432\\u0435\\u0442\\"","\\u041c\\u041a\\u041f \\u0433. \\u0410\\u0441\\u0442\\u0440\\u0430\\u0445\\u0430\\u043d\\u0438 \\"\\u0413\\u043e\\u0440\\u0441\\u0432\\u0435\\u0442\\"","\\u041c\\u041a\\u041f \\u0433. \\u0410\\u0441\\u0442\\u0440\\u0430\\u0445\\u0430\\u043d\\u0438 \\"\\u0413\\u043e\\u0440\\u0441\\u0432\\u0435\\u0442\\""]	Светильник	f	{"default":"\\u041c\\u041a\\u041f \\u0433. \\u0410\\u0441\\u0442\\u0440\\u0430\\u0445\\u0430\\u043d\\u0438 \\"\\u0413\\u043e\\u0440\\u0441\\u0432\\u0435\\u0442\\""}
106	constructed_3	Балансовая стоимость / принадлежность к балансовой стоимости сетевого комплекса	carrying_amount	f	text_field	2020-03-16 10:09:59	2020-03-16 10:44:37	null	Светильник	f	{"min":1,"max":100}
107	constructed_3	Остаточная стоимость / принадлежность к остаточной стоимости сетевого комплекса	residual_value	f	text_field	2020-03-16 10:09:59	2020-03-16 10:44:37	null	Светильник	f	{"min":1,"max":100}
108	constructed_3	Дата монтажа / установки светильника	date	f	date_field	2020-03-16 10:09:59	2020-03-16 10:22:35	null	Светильник	f	{"minDate":null,"maxDate":null}
121	constructed_3	Габариты (вынос)	rice	f	number_field	2020-03-16 10:34:43	2020-03-16 10:35:18	null	Кронштейн	f	{"min":null,"max":null}
125	constructed_3	Право собственности	bracket_property_rights	f	one_from_many_field	2020-03-16 10:34:43	2020-03-16 10:35:18	["\\u0410\\u0434\\u043c\\u0438\\u043d\\u0438\\u0441\\u0442\\u0440\\u0430\\u0446\\u0438\\u044f \\u041c\\u041e \\"\\u0413\\u043e\\u0440\\u043e\\u0434 \\u0410\\u0441\\u0442\\u0440\\u0430\\u0445\\u0430\\u043d\\u044c\\"","\\u0422\\u041e \\/ \\u0441\\u043e\\u0431\\u0441\\u0442\\u0432\\u0435\\u043d\\u043d\\u0438\\u043a","\\u0431\\u0435\\u0441\\u0445\\u043e\\u0437"]	Кронштейн	f	{"default":"\\u0410\\u0434\\u043c\\u0438\\u043d\\u0438\\u0441\\u0442\\u0440\\u0430\\u0446\\u0438\\u044f \\u041c\\u041e \\"\\u0413\\u043e\\u0440\\u043e\\u0434 \\u0410\\u0441\\u0442\\u0440\\u0430\\u0445\\u0430\\u043d\\u044c\\""}
98	constructed_3	Мощность лампы / светильника (Ватт)	lamp_power	f	text_field	2020-03-16 10:05:32	2020-03-16 10:44:37	null	Светильник	f	{"min":1,"max":100}
176	constructed_6	Дата последнего ТО-3	date_last_3	f	date_field	2020-03-26 05:32:32	2020-03-26 05:34:24	null	Свойства	f	{"minDate":null,"maxDate":null}
177	constructed_6	Дата следующего ТО-3	date_next_3	f	date_field	2020-03-26 05:32:32	2020-03-26 05:34:24	null	Свойства	f	{"minDate":null,"maxDate":null}
142	constructed_3	Инвентарный номер опоры / принадлежность к инвентарному номеру сетевого комплекса	bracket_inventory_number	f	text_field	2020-03-16 11:13:33	2020-03-16 11:40:51	null	Кронштейн	f	{"min":1,"max":100}
143	constructed_3	Балансовая стоимость / принадлежность к балансовой стоимости сетевого комплекса	bracket_carrying_amount	f	text_field	2020-03-16 11:13:33	2020-03-16 11:40:51	null	Кронштейн	f	{"min":1,"max":100}
144	constructed_3	Остаточная стоимость / принадлежность к остаточной стоимости сетевого комплекса	bracket_residual_value	f	text_field	2020-03-16 11:13:33	2020-03-16 11:40:51	null	Кронштейн	f	{"min":1,"max":100}
146	constructed_3	Нормативный срок службы (лет)	bracket_service_life	f	number_field	2020-03-16 11:13:33	2020-03-16 11:40:51	null	Кронштейн	f	{"min":null,"max":null}
147	constructed_3	Наработка (лет)	bracket_age	f	number_field	2020-03-16 11:13:33	2020-03-16 11:40:51	null	Кронштейн	f	{"min":null,"max":null}
178	constructed_6	Дата последнего кап.ремонта	date_last	f	date_field	2020-03-26 05:32:32	2020-03-26 05:34:24	null	Свойства	f	{"minDate":null,"maxDate":null}
179	constructed_6	Дата следующего кап.ремонта	date_next	f	date_field	2020-03-26 05:32:32	2020-03-26 05:34:24	null	Свойства	f	{"minDate":null,"maxDate":null}
181	constructed_6	Дата монтажа / установки	counter_date	f	date_field	2020-03-26 05:41:28	2020-03-26 05:44:06	null	Счётчик	f	{"minDate":null,"maxDate":null}
184	constructed_6	Дата последней поверки счетчика	counter_date_last	f	date_field	2020-03-26 05:44:06	2020-03-26 05:46:58	null	Счётчик	f	{"default":null,"minDate":null,"maxDate":null}
148	constructed_3	Дата последнего ТО-1	bracket_date_last_1	f	date_field	2020-03-16 11:16:20	2020-03-16 11:40:51	null	Кронштейн	f	{"minDate":null,"maxDate":null}
149	constructed_3	Дата следующего ТО-1	bracket_date_next_1	f	date_field	2020-03-16 11:16:20	2020-03-16 11:40:51	null	Кронштейн	f	{"minDate":null,"maxDate":null}
150	constructed_3	Дата последнего ТО-2	bracket_date_last_2	f	date_field	2020-03-16 11:16:20	2020-03-16 11:40:51	null	Кронштейн	f	{"minDate":null,"maxDate":null}
185	constructed_6	Дата следующей поверки счетчика	counter_date_next	f	date_field	2020-03-26 05:44:06	2020-03-26 05:46:58	null	Счётчик	f	{"minDate":null,"maxDate":null}
186	constructed_6	Дата последней поверки трансформаторов тока	amperage_date_last	f	date_field	2020-03-26 05:44:06	2020-03-26 05:46:58	null	Счётчик	f	{"minDate":null,"maxDate":null}
187	constructed_6	Дата следующей поверки трансформаторов тока	amperage_date_next	f	date_field	2020-03-26 05:44:06	2020-03-26 05:46:58	null	Счётчик	f	{"minDate":null,"maxDate":null}
145	constructed_3	Дата монтажа / установки светильника	bracket_date	f	date_field	2020-03-16 11:13:33	2020-03-16 11:16:20	null	Кронштейн	f	{"minDate":null,"maxDate":null}
158	constructed_2	Предыдущая опора (список)	opora	f	link_field	2020-03-19 10:05:00	2020-03-19 10:11:26	null	Связь	f	{"layers":[{"id":2,"alias":"opory","title":"\\u041e\\u043f\\u043e\\u0440\\u044b","description":null,"parent_id":null,"module_id":2,"visibility":true,"geometry_type":"point","style":{"id":1,"shape":{"points":"4","fill":{"color":"#4FBBC5"},"stroke":{"color":"#C58A6E","width":"3"},"radius":"5"},"icon":{"src":"https:\\/\\/api.city-panorama.ru\\/storage\\/images\\/layers\\/XfvRfZ2h7CjMxCBxJqA1j7KPOGh7pbE6eKvTWchh.png","anchor":[12,12],"opacity":0,"scale":1,"rotation":0},"pointType":"shape","font":{"font":"16px Calibri, sans-serif","fill":{"color":"#000000"},"stroke":{"color":"#ffffff","width":3},"textBaseline":"bottom","offsetY":-6},"list":{"hasList":"false","visibility":"false","color":"#BE6969","opacity":"50"}},"created_at":null,"updated_at":"2020-03-19 10:04:13","module":{"id":2,"title":"\\u0413\\u043e\\u0440\\u0441\\u0432\\u0435\\u0442","description":"<p>\\u041c\\u0423\\u041d\\u0418\\u0426\\u0418\\u041f\\u0410\\u041b\\u042c\\u041d\\u041e\\u0415 \\u041a\\u0410\\u0417\\u0415\\u041d\\u041d\\u041e\\u0415 \\u041f\\u0420\\u0415\\u0414\\u041f\\u0420\\u0418\\u042f\\u0422\\u0418\\u0415 \\u0413\\u041e\\u0420\\u041e\\u0414\\u0410 \\u0410\\u0421\\u0422\\u0420\\u0410\\u0425\\u0410\\u041d\\u0418 \\"\\u0413\\u041e\\u0420\\u0421\\u0412\\u0415\\u0422\\"<\\/p>","created_at":null,"updated_at":"2019-09-26 12:41:52"},"parent":null}]}
156	constructed_6	Трансформаторный пункт	parent	f	link_field	2020-03-16 11:21:24	2020-03-16 11:35:23	null	Свойства ПП	t	{"layers":[{"id":7,"alias":"tp","title":"\\u0422\\u041f","description":null,"parent_id":null,"module_id":2,"visibility":true,"geometry_type":"point","style":{"id":1,"shape":{"points":11,"fill":{"color":"#009fe3","opacity":0},"stroke":{"color":"#164194","width":1,"opacity":0},"radius":5,"rotation":0},"icon":{"src":"http:\\/\\/api.city-panorama.ru\\/storage\\/images\\/layer\\/default.png","anchor":[24,24],"opacity":0,"scale":1,"rotation":0},"pointType":"shape","font":{"font":"16px Calibri, sans-serif","textBaseline":"bottom","offsetY":-6,"fill":{"color":"#000000"},"stroke":{"color":"#ffffff","width":3}},"list":{"hasList":false,"visibility":false,"color":"#000000","opacity":0}},"created_at":"2020-03-16 11:20:53","updated_at":"2020-03-16 11:20:53","module":{"id":2,"title":"\\u0413\\u043e\\u0440\\u0441\\u0432\\u0435\\u0442","description":"<p>\\u041c\\u0423\\u041d\\u0418\\u0426\\u0418\\u041f\\u0410\\u041b\\u042c\\u041d\\u041e\\u0415 \\u041a\\u0410\\u0417\\u0415\\u041d\\u041d\\u041e\\u0415 \\u041f\\u0420\\u0415\\u0414\\u041f\\u0420\\u0418\\u042f\\u0422\\u0418\\u0415 \\u0413\\u041e\\u0420\\u041e\\u0414\\u0410 \\u0410\\u0421\\u0422\\u0420\\u0410\\u0425\\u0410\\u041d\\u0418 \\"\\u0413\\u041e\\u0420\\u0421\\u0412\\u0415\\u0422\\"<\\/p>","created_at":null,"updated_at":"2019-09-26 12:41:52"},"parent":null}]}
151	constructed_3	Дата следующего ТО-2	bracket_date_next_2	f	date_field	2020-03-16 11:16:20	2020-03-16 11:40:51	null	Кронштейн	f	{"minDate":null,"maxDate":null}
155	constructed_3	Дата следующего кап.ремонта	bracket_date_next	f	date_field	2020-03-16 11:16:20	2020-03-16 11:40:51	null	Кронштейн	f	{"minDate":null,"maxDate":null}
82	constructed_2	Инвентарный номер опоры / принадлежность к инвентарному номеру сетевого комплекса	inventory	f	text_field	2020-03-16 08:10:25	2020-03-19 10:04:13	null	Дополнительные свойства	f	{"min":1,"max":100}
84	constructed_2	Остаточная стоимость / принадлежность к остаточной стоимости сетевого комплекса	residual_amount	f	text_field	2020-03-16 08:10:25	2020-03-19 10:04:13	null	Дополнительные свойства	f	{"min":1,"max":100}
172	constructed_6	Дата последнего ТО-1	date_last_1	f	date_field	2020-03-26 05:32:32	2020-03-26 05:34:24	null	Свойства	f	{"minDate":null,"maxDate":null}
175	constructed_6	Дата следующего ТО-2	date_next_2	f	date_field	2020-03-26 05:32:32	2020-03-26 05:34:24	null	Свойства	f	{"minDate":null,"maxDate":null}
157	constructed_6	Трансформаторный пунтк	tp	f	link_field	2020-03-16 11:35:57	2020-03-26 05:36:31	null	Дополнительные свойства	f	{"layers":[{"id":7,"alias":"tp","title":"\\u0422\\u0440\\u0430\\u043d\\u0441\\u0444\\u043e\\u0440\\u043c\\u0430\\u0442\\u043e\\u0440\\u043d\\u044b\\u0435 \\u043f\\u0443\\u043d\\u043a\\u0442\\u044b","description":null,"parent_id":null,"module_id":2,"visibility":true,"geometry_type":"point","style":{"id":1,"shape":{"points":"4","fill":{"color":"#F4CFF6","opacity":0},"stroke":{"color":"#FF0000","width":1,"opacity":0},"radius":"20","rotation":0.78539816339744828},"icon":{"src":"http:\\/\\/api.city-panorama.ru\\/storage\\/images\\/layer\\/default.png","anchor":[24,24],"opacity":0,"scale":1,"rotation":0},"pointType":"shape","font":{"font":"16px Calibri, sans-serif","textBaseline":"bottom","offsetY":-6,"fill":{"color":"#000000"},"stroke":{"color":"#ffffff","width":3}},"list":{"hasList":false,"visibility":false,"color":"#000000","opacity":0}},"created_at":"2020-03-16 11:20:53","updated_at":"2020-03-16 11:31:13","module":{"id":2,"title":"\\u0413\\u043e\\u0440\\u0441\\u0432\\u0435\\u0442","description":"<p>\\u041c\\u0423\\u041d\\u0418\\u0426\\u0418\\u041f\\u0410\\u041b\\u042c\\u041d\\u041e\\u0415 \\u041a\\u0410\\u0417\\u0415\\u041d\\u041d\\u041e\\u0415 \\u041f\\u0420\\u0415\\u0414\\u041f\\u0420\\u0418\\u042f\\u0422\\u0418\\u0415 \\u0413\\u041e\\u0420\\u041e\\u0414\\u0410 \\u0410\\u0421\\u0422\\u0420\\u0410\\u0425\\u0410\\u041d\\u0418 \\"\\u0413\\u041e\\u0420\\u0421\\u0412\\u0415\\u0422\\"<\\/p>","created_at":null,"updated_at":"2019-09-26 12:41:52"},"parent":null}]}
188	constructed_6	Показания счетчика (кВтч) на начало периода	meter_1	f	number_field	2020-03-26 05:46:58	2020-04-27 05:56:45	null	Счётчик	f	{"min":null,"max":null}
189	constructed_6	Показания счетчика (кВтч) на конец периода	meter_2	f	number_field	2020-03-26 05:46:58	2020-04-27 05:56:45	null	Счётчик	f	{"min":null,"max":null}
190	constructed_6	Показания счетчика (кВтч) накопительно	meter_3	f	number_field	2020-03-26 05:46:58	2020-04-27 05:56:45	null	Счётчик	f	{"min":null,"max":null}
191	constructed_6	Отклонения	deviasion	f	number_field	2020-03-26 05:46:58	2020-04-27 05:56:45	null	Счётчик	f	{"min":null,"max":null}
71	constructed_2	Питающий пункт	feeding_point	f	link_field	2020-03-05 14:17:39	2020-03-19 10:09:14	null	Связь	f	{"layers":[{"id":6,"alias":"pitayushchiye-punkty","title":"\\u041f\\u0438\\u0442\\u0430\\u044e\\u0449\\u0438\\u0435 \\u043f\\u0443\\u043d\\u043a\\u0442\\u044b","description":null,"parent_id":null,"module_id":2,"visibility":true,"geometry_type":"point","style":{"id":1,"shape":{"points":"4","fill":{"color":"#009fe3","opacity":0},"stroke":{"color":"#164194","width":1,"opacity":0},"radius":"16","rotation":0.78539816339744828},"icon":{"src":"https:\\/\\/api.city-panorama.ru\\/storage\\/images\\/layer\\/default.png","anchor":[24,24],"opacity":0,"scale":1,"rotation":0},"pointType":"shape","font":{"font":"16px Calibri, sans-serif","textBaseline":"bottom","offsetY":-6,"fill":{"color":"#000000"},"stroke":{"color":"#ffffff","width":3}},"list":{"hasList":false,"visibility":false,"color":"#000000","opacity":0}},"created_at":"2020-03-02 07:17:12","updated_at":"2020-03-05 14:15:51","module":{"id":2,"title":"\\u0413\\u043e\\u0440\\u0441\\u0432\\u0435\\u0442","description":"<p>\\u041c\\u0423\\u041d\\u0418\\u0426\\u0418\\u041f\\u0410\\u041b\\u042c\\u041d\\u041e\\u0415 \\u041a\\u0410\\u0417\\u0415\\u041d\\u041d\\u041e\\u0415 \\u041f\\u0420\\u0415\\u0414\\u041f\\u0420\\u0418\\u042f\\u0422\\u0418\\u0415 \\u0413\\u041e\\u0420\\u041e\\u0414\\u0410 \\u0410\\u0421\\u0422\\u0420\\u0410\\u0425\\u0410\\u041d\\u0418 \\"\\u0413\\u041e\\u0420\\u0421\\u0412\\u0415\\u0422\\"<\\/p>","created_at":null,"updated_at":"2019-09-26 12:41:52"},"parent":null}]}
160	constructed_6	Тип	kind_type	f	one_from_many_field	2020-03-26 05:16:47	2020-03-26 05:21:06	["\\u0428\\u0423\\u0412","\\u0418\\u041f\\u0420\\u0428","\\u0420\\u041a\\u0428","\\u0428\\u041e-59"]	Свойства	f	{"default":"\\u0428\\u0423\\u0412"}
159	constructed_6	Вид пункта питания	kind	f	one_from_many_field	2020-03-26 05:15:19	2020-03-26 05:21:48	["\\u0418\\u0441\\u043f\\u043e\\u043b\\u043d\\u0438\\u0442\\u0435\\u043b\\u044c\\u043d\\u044b\\u0439 \\u043f\\u0443\\u043d\\u043a\\u0442","\\u041f\\u0443\\u043d\\u043a\\u0442 \\u043f\\u0438\\u0442\\u0430\\u043d\\u0438\\u044f","\\u0410\\u0432\\u0442\\u043e\\u043c\\u0430\\u0442\\u0438\\u0447\\u0435\\u0441\\u043a\\u043e\\u0433\\u043e \\u0443\\u043f\\u0440\\u0430\\u0432\\u043b\\u0435\\u043d\\u0438\\u044f"]	Свойства	f	{"default":"\\u0418\\u0441\\u043f\\u043e\\u043b\\u043d\\u0438\\u0442\\u0435\\u043b\\u044c\\u043d\\u044b\\u0439 \\u043f\\u0443\\u043d\\u043a\\u0442"}
161	constructed_6	Право собственности	property_rights	f	one_from_many_field	2020-03-26 05:21:06	2020-03-26 05:21:48	["\\u0410\\u0434\\u043c\\u0438\\u043d\\u0438\\u0441\\u0442\\u0440\\u0430\\u0446\\u0438\\u044f \\u041c\\u041e \\"\\u0413\\u043e\\u0440\\u043e\\u0434 \\u0410\\u0441\\u0442\\u0440\\u0430\\u0445\\u0430\\u043d\\u044c\\"","\\u0422\\u041e\\/\\u0441\\u043e\\u0431\\u0441\\u0442\\u0432\\u0435\\u043d\\u043d\\u0438\\u043a","\\u0431\\u0435\\u0437\\u0445\\u043e\\u0437"]	Свойства	f	{"default":"\\u0410\\u0434\\u043c\\u0438\\u043d\\u0438\\u0441\\u0442\\u0440\\u0430\\u0446\\u0438\\u044f \\u041c\\u041e \\"\\u0413\\u043e\\u0440\\u043e\\u0434 \\u0410\\u0441\\u0442\\u0440\\u0430\\u0445\\u0430\\u043d\\u044c\\""}
162	constructed_6	Право владения / пользования	ownership	f	one_from_many_field	2020-03-26 05:21:06	2020-03-26 05:21:48	["\\u041c\\u041a\\u041f \\u0433. \\u0410\\u0441\\u0442\\u0440\\u0430\\u0445\\u0430\\u043d\\u0438 \\"\\u0413\\u043e\\u0440\\u0441\\u0432\\u0435\\u0442\\"","\\u0422\\u041e\\/\\u0441\\u043e\\u0431\\u0441\\u0442\\u0432\\u0435\\u043d\\u043d\\u0438\\u043a","\\u0431\\u0435\\u0437\\u0445\\u043e\\u0437"]	Свойства	f	{"default":"\\u041c\\u041a\\u041f \\u0433. \\u0410\\u0441\\u0442\\u0440\\u0430\\u0445\\u0430\\u043d\\u0438 \\"\\u0413\\u043e\\u0440\\u0441\\u0432\\u0435\\u0442\\""}
163	constructed_6	Эксплуатирующая организация	organization	f	one_from_many_field	2020-03-26 05:21:06	2020-03-26 05:21:48	["\\u041c\\u041a\\u041f \\u0433. \\u0410\\u0441\\u0442\\u0440\\u0430\\u0445\\u0430\\u043d\\u0438 \\"\\u0413\\u043e\\u0440\\u0441\\u0432\\u0435\\u0442\\"","\\u041c\\u041a\\u041f \\u0433. \\u0410\\u0441\\u0442\\u0440\\u0430\\u0445\\u0430\\u043d\\u0438 \\"\\u0413\\u043e\\u0440\\u0441\\u0432\\u0435\\u0442\\"","\\u041c\\u041a\\u041f \\u0433. \\u0410\\u0441\\u0442\\u0440\\u0430\\u0445\\u0430\\u043d\\u0438 \\"\\u0413\\u043e\\u0440\\u0441\\u0432\\u0435\\u0442\\""]	Свойства	f	{"default":"\\u041c\\u041a\\u041f \\u0433. \\u0410\\u0441\\u0442\\u0440\\u0430\\u0445\\u0430\\u043d\\u0438 \\"\\u0413\\u043e\\u0440\\u0441\\u0432\\u0435\\u0442\\""}
164	constructed_6	Улица	street	f	text_field	2020-03-26 05:22:37	2020-03-26 05:36:31	null	Свойства	f	{"min":1,"max":100}
165	constructed_6	Номер дома	building	f	text_field	2020-03-26 05:22:37	2020-03-26 05:36:31	null	Свойства	f	{"min":1,"max":100}
81	constructed_2	Эксплуатирующая организация	organization	f	one_from_many_field	2020-03-16 08:08:48	2020-03-26 06:09:13	["\\u041c\\u041a\\u041f \\u0433. \\u0410\\u0441\\u0442\\u0440\\u0430\\u0445\\u0430\\u043d\\u0438 \\"\\u0413\\u043e\\u0440\\u0441\\u0432\\u0435\\u0442\\"","\\u041c\\u0423 \\u0410\\u0422\\u041f","\\u041c\\u0420\\u0421\\u041a","\\u0420\\u043e\\u0441\\u0442\\u0435\\u043b\\u0435\\u043a\\u043e\\u043c"]	Дополнительные свойства	f	{"default":"\\u041c\\u041a\\u041f \\u0433. \\u0410\\u0441\\u0442\\u0440\\u0430\\u0445\\u0430\\u043d\\u0438 \\"\\u0413\\u043e\\u0440\\u0441\\u0432\\u0435\\u0442\\""}
180	constructed_6	Марка счетчика	counter_brand	f	text_field	2020-03-26 05:38:41	2020-04-27 05:56:45	null	Счётчик	f	{"min":1,"max":100}
\.


--
-- Name: constructor_metadata_id_seq; Type: SEQUENCE SET; Schema: public; Owner: smartcity
--

SELECT pg_catalog.setval('public.constructor_metadata_id_seq', 191, true);


--
-- Data for Name: contractors; Type: TABLE DATA; Schema: public; Owner: smartcity
--

COPY public.contractors (id, name, full_name, inn, kpp, address_id, created_at, updated_at) FROM stdin;
1	Администратор	Администратор	301711648261	\N	\N	\N	\N
2	ООО "РЕАЛЬНЫЙ ГОРОД"	ОБЩЕСТВО С ОГРАНИЧЕННОЙ ОТВЕТСТВЕННОСТЬЮ "РЕАЛЬНЫЙ ГОРОД"	3019015479	301901001	\N	\N	\N
4	Администратор ТОС	Администратор слоя ТОС	301608343954	\N	2	2019-09-26 19:59:46	2019-09-26 19:59:46
5	МКП г. Астрахани "ГОРСВЕТ"	МУНИЦИПАЛЬНОЕ КАЗЕННОЕ ПРЕДПРИЯТИЕ ГОРОДА АСТРАХАНИ "ГОРСВЕТ"	3018311926	301801001	3	2020-03-02 06:57:54	2020-04-27 17:28:35
\.


--
-- Name: contractors_id_seq; Type: SEQUENCE SET; Schema: public; Owner: smartcity
--

SELECT pg_catalog.setval('public.contractors_id_seq', 5, true);


--
-- Data for Name: geo_elements; Type: TABLE DATA; Schema: public; Owner: smartcity
--

COPY public.geo_elements (id, layer_id, title, description, address_id, geometry, length, area, perimeter, created_at, updated_at, element_next_id) FROM stdin;
1	1	ТОС МУК		\N	0103000000010000005400000003BA6100BC0748405F8BEF23DC2D47402FBAE1ADCA07484037BF0272DE2D4740E6B96142D407484096DCD64BE12D47401EBA6147DE07484034B910C8E12D47402FBAE1F2DF074840F4934A44E22D474003BA61D0EB0748400C015E2FED2D4740FEB961FAEE074840662292B3EE2D4740E7B96113F4074840A85D615EEF2D4740CCB9E1BBF80748403FC3474FF12D474026BA6137FD074840777BAF57F42D4740D3B961BB00084840129A339EF72D4740C6B961470B084840D5D94252FF2D4740CAB9E13812084840D27E3E89022E474025BA61FA1B08484079F9723C062E474011BAE1852E0848401404A81E0C2E4740DBB961425B084840459A23FA162E47409DB9E10E69084840E8BEEAAC182E4740B6B9611F6F084840A067150A192E4740C9B9613D7E0848407774DC5E162E47409EB9617D89084840CFC18675132E474082B961C0910848405725E327132E4740A6B961B2BD084840B2E3386F1A2E47405EB9E199DD08484004EAA29E1E2E474071B961B037094840A4C386A12C2E4740EAB8E1FD78094840B156C5F8352E47404EB9612577094840AF005BAC3B2E474014B9E13B770948402745A9C4402E47400BB96174730948405CF43DCE492E474021B961D977094840EDF16C524B2E474009B9E18F7D094840A3EF88904B2E4740F6B8E17D8F094840779B7BC74E2E474010B9611AA0094840BE6580EE4F2E474038B9E173A8094840633DD4A8502E47402BB9E1B9AD094840F8EE5FDF512E4740CAB8E102B00948408F9CDDF6522E474033B96181B1094840E962563D562E47400CB96151B4094840807D3AFF552E4740F0B8E1BCD70948401ED983175B2E4740E1B8E13AE1094840FA8CE9175D2E4740E4B861FC170A484024445B8D622E4740BBB86110400A48402BEDED11662E47408BB861B63F0A4840868270275D2E4740E1B8E1A14C0A4840E7CDF7992D2E4740C2B861BA590A484007BCF060FB2D4740CDB8E149590A4840EECF4E73E42D474066B86193530A48406F0116FCB32D4740BCB861D74B0A484099CE854A952D474061B8E15B470A4840F7BCF113942D4740B3B8E103270A48408DF38742942D4740A8B8612E220A4840FDF82C90942D4740F5B8E1D7E9094840FB05E5EC922D4740D8B8E1D4EC09484096F4553F862D4740CEB8618BF2094840B9AA8B85452D4740C4B861DFF809484008ABCE18052D4740C7B861EDF9094840ADCF7559F02C47409CB86169F60948400D8A30D3E62C4740DEB8E1F0EE09484088518691D82C4740F8B8E1E5EA094840981E85BBC62C4740D0B8E16FE8094840FFE2526CC02C4740F9B8614BE709484090121915B92C4740C5B8E17DE9094840A69E7CD38D2C4740F2B8E1C9E80948404033D5A3892C4740BDB861FCEA094840B9AC5DC26A2C474002B96175EA094840C95D2692642C474016B9E131EA09484008040BE4572C47402FB961F1B909484007445277572C4740D4B8E168A4094840F7BEE09D562C474063B9E16C9109484087A4C676552C474096B9E11084094840187FC7846C2C474099B9E1D96F094840473B65D9862C474078B9E13A5A0948409D8F7D729C2C47406BB9E1743E0948404C6155AEB12C4740EAB9E1A40E09484015FD6167CB2C4740C6B9E1B2E20848409FB5EC54DE2C4740E4B9E1A09A08484024F33AE8FC2C474046BAE14C6708484044CD8FB7132D474037BAE1BE4F0848404599372F212D4740F5B9E10E3C084840D19580FC2F2D47405EBAE1E22B084840D77C0D653F2D474067BAE148200848408EBC26E44B2D474018BAE117060848402B9F8DCD6F2D47403FBAE13BE20748401A465A8BA12D474086BAE137C80748408AB4B64DC62D474003BA6100BC0748405F8BEF23DC2D4740	0	0.000183526209303957755	0.062288963242218838	\N	\N	\N
2	1	ТОС УК "КонсалтингПроф"		\N	01030000000100000043000000708A867186FD474002D0C2A3762E47405A8A865197FD47406F9CD5FC892E4740608A06519FFD474027BA327A902E4740128A0672ABFD4740F29EA935972E47407F8A0628B9FD474098FF5F3E9C2E4740768A06C2C4FD4740A23AEBC29F2E4740248A060EC4FD4740BB39BB09A52E47407A8A0616CBFD4740D3CF80F4AF2E4740368A86C6D6FD47405BC5F1C0BE2E47403F8A8671E0FD4740799541B3C82E4740378A868DE2FD4740345BEF94CC2E4740FE890630EDFD4740D00DE916ED2E4740538A868FEFFD4740CB060DC2EF2E4740248A86C1F9FD4740787F58CAF22E47403A8A8626FEFD4740BD15B3CAF42E4740008A862004FE4740951E56DC002F4740528A86D404FE4740DB98303A052F4740548A064415FE474015ED0BB6032F4740398A06942EFE47408E03A002FE2E4740278A060437FE4740D3390BF2F72E4740C98986F83AFE474093335F5EF62E4740EE8986EB56FE47406BBD306DF22E4740068A861857FE4740FB975E55EF2E4740EF8906F1B2FE4740778A9E69DE2E4740AC89862CD9FE4740DC86B1C5D82E4740B4898691DDFE474093F053ECD72E4740CD8986CBEEFE4740DC86B1C5D82E4740208986B59AFF47407F602175F32E47402F8906F7E7FF4740BB0639C5012F4740D3880697EDFF4740A8CD5D49032F4740E08886FA0900484012CE3246F12E4740D3888634EEFF4740F24E8B1AD62E4740108986540A004840AA185C18CA2E4740B288862C1400484023211ABAC32E4740A288060C2D004840D107785BBB2E4740C0880691200048401ADA54FBAA2E4740008986501D004840919CF185A52E47401589064701004840810F27EC832E4740CB8806F80400484002D6C612832E4740CD8806C0000048403CA46426492E4740CB8806B3EFFF474020C88E9E352E474018898668D8FF474057BB8897132E47402D8986C0CBFF4740753B328C022E47400C8986E8C1FF47403E7F2DC3052E4740FE8886DCA0FF4740039C0188132E4740528986589DFF474002A5EC9F162E47405389063D93FF4740B7C9333B172E47403389066589FF47406438C1FE1E2E47403D89061183FF4740EF95F282202E47402D8986E47AFF4740A0BE32F71F2E47407289860230FF4740FE7F44AD312E47402A8906DE2EFF4740AC7FCD8D2F2E47409E89868723FF4740CE332077322E4740A28906FB20FF47407B1F2CC5342E47408C8906961CFF474059D93713372E4740558906D717FF47407B1F2CC5342E4740658986F7FEFE474023E9780C3C2E4740AA8986A0CEFE47408E94F42D482E47408E8986D7B5FE4740A47186E14D2E47408D898691B0FE4740A5A78E83492E4740F689068FABFE47407D811964472E4740DE89867EA5FE4740E1842783472E4740B38986FAA1FE474008A148E8482E4740048A86E796FE474040FC327D502E4740E18906E591FE474046393973452E4740FD8986E232FE4740DC164A40562E4740708A867186FD474002D0C2A3762E4740	0	9.54685389799203073e-05	0.0512526346228533505	\N	\N	\N
4	1	ТОС Альянс		\N	0103000000010000000B000000EB8886C1DAFE47406AE7F7F4DB3547408A8A86F3F5FC4740A2F18DFD5B3547404A8A8693AFFD47407D5ABFEBEE344740E689862B08FE47400FBB9D5E10354740758986137AFE47407A3032FDBC3447402189867FEFFE4740322D8380CC344740F68886CB1BFF474001A54897D9344740138986132EFF474085E259D4F1344740968986EB83FE47409A8E16A4173547403889868750FF4740633AA05081354740EB8886C1DAFE47406AE7F7F4DB354740	0	8.07777537243769276e-05	0.0519033109941119467	\N	\N	\N
5	1	ТОС Эллинг		\N	010300000001000000170000008F295CE2A90248406C92E3901E2C47405E3E5C8E1C024840355A167D632C47401B405C320F0248409D9C5117602C4740F8435C7AF4014840E77E1D50692C474091485CD6D4014840EE5604D7572C4740134B5CF6C3014840EDD76647492C47400C5C5C3E4F0148402A486D62032C4740D7665CB604014840CCAB392FD82B4740A9645C12120148405CD23CF6CE2B4740F7775C2E8D0048401AA205C8812B4740A3825C5A43004840F2393C6C3A2B4740907C5C8A6D0048403266EE7F162B4740C8745CFAA200484042436187152B474008705C6EC5004840477B4ED90A2B47403A695C8AF40048401F7825D23D2B4740445F5C56370148409C78306C6C2B4740D05A5C62580148402B68A1B1842B47408A495C82CE014840E63D6E8EAA2B474042415C2A0802484088C93984BC2B474079375C424A024840FD7F5E02DE2B4740BC295C2EA902484010B2A1141E2C4740E9295C7AA80248406C92E3901E2C47408F295CE2A90248406C92E3901E2C4740	0	6.89804203929954735e-05	0.0446959672356576215	\N	\N	\N
6	1	ТОС Комсомольская набережная		\N	010300000001000000130000003E806F3E470648407BA307D79A30474021836FDA320648403006904B9C304740F4826F8E330648407EC4C1328F304740FB816FE239064840414926D58A304740FA826FAA350648407B035F0C53304740B1856FFA210648406C87248E42304740278E6F9EE7054840046DC69541304740DF926F46C7054840FF6A6153E82F474080996FDE98054840F15796BEA92F4740649C6F7A84054840DC456F84902F4740649C6F7A840548405EBE27917E2F47401C966F7AB1054840C7AA71CB662F474096896F26050648404471DB5B542F4740FB816FE239064840B723400D4E2F4740AC7A6F366D064840154E83E2783047400D7C6F7A6506484039F89C60893047408E7C6F4261064840D3046E7996304740C57F6F5A490648407BA307D79A3047403E806F3E470648407BA307D79A304740	0	3.75284114160009347e-05	0.0291673169103960801	\N	\N	\N
7	1	ТОС Союз		\N	0103000000010000000A0000001387AD1D14064840315110A2552E4740AD97ADB19E054840C7028C655D2E4740029EEBC86F054840AEE35EB4632E474034A9EBD823054840569ABA33742E474023B1EB98EB0448404C50432F852E4740A4A6EBB8340548404ECEF7C2052F4740EDA1EB10550548401C1F422E5A2F4740AD9BEBF47F05484077633DBC682F47403C81EB78370648405D3B6ED5442F47401387AD1D14064840315110A2552E4740	0	6.03776395078808902e-05	0.030941242864966953	\N	\N	\N
8	1	ТОС Благополучие		\N	01030000000100000006000000F145DFB58C0C484045EE83F535314740B145DF4B7E0C4840BA6ED460283147403445DFD73C0D48406CBE41D69F3047405645DFF54B0D4840ED8C0F44AA3047402645DF9B4B0D484037F3F805AA304740F145DFB58C0C484045EE83F535314740	0	3.98917984289688867e-06	0.0155550765341718744	\N	\N	\N
9	1	ТОС Спутник		\N	0103000000010000000E0000003B48BC50F9064840CA845279C82C4740C047BC805007484029EA54D1302D47405247BC48000848404A277089082D47401947BC583B08484083C930FAF92C47405C47BCD04A08484003CFF27DF92C4740D746BC54A8084840D322D348DF2C4740DD46BC581C09484066364F0BA52C47406646BC545C094840BAC354A0702C47406246BCC46409484005C977D0592C47401647BC48E10848401D68F9C85A2C4740B247BC445F0748405A011AE8772C4740AC47BC1C3C0748405C6E5E0A842C4740E947BC6C280748404C5B1E8E832C47403B48BC50F9064840CA845279C82C4740	0	7.27481425331610301e-05	0.042283772542806651	\N	\N	\N
10	1	ТОС Любимый город		\N	01030000000100000009000000AC47BC285D0748403ACC18F7752C4740ED47BCD8700748400086023B1A2C4740B447BCF4CC074840940DF6AF962B47401447BC80E508484026359AA9EA2B47408746BCFC950948409FA9F258162C47407C46BC447B094840CF556DFD532C47404A47BC281108484072EACBE3672C4740D947BC745C074840C01C5973762C4740AC47BC285D0748403ACC18F7752C4740	0	7.0167715465713131e-05	0.0409255386702226526	\N	\N	\N
11	1	ТОС Тютчева		\N	0103000000010000000A00000070475B5F4F0748409163177CDF2D47408E475B4BAE07484007A6BFCCED2D47408A475BC7D70748403C9C3F48A42D47403E475B471B084840255612814A2D47401A475B55EF0748401A87FE31442D47402B475B59DC074840BBD40B41422D474089475B996007484075603ECE482D4740B0475BC95D074840255C378E402D474068475BC15607484058879F573F2D474070475B5F4F0748409163177CDF2D4740	0	2.19554384200532546e-05	0.0200286461138673919	\N	\N	\N
12	1	ТОС КАМА		\N	01030000000100000015000000FB4F15AE22F847407828E942BC244740EB4F15FEB4F74740C46E23187D244740E44F15A6C1F74740B3D3280F6D244740535015C683F747406E3AE2F54D2447400750157697F74740DEB5388D392447403650158A92F74740FEF90FCE30244740535015C683F74740AABDE70A06244740E04F1522EBF7474018031662C6234740E64F154A0EF84740A642F20DE32347405D4F153207F94740F2BCB395042447403A4F156231F947404A551CCC1F2447403C4F15364EF94740B15651F7192447402C4F153261F94740BE3273B8332447406F4F15CE1FF94740959D62DE3F244740554F156697F84740A8729E093A244740654F156A84F847409AADA19B37244740C94F15AE7CF84740A9B031693E244740994F150256F84740AA07CCEC3D244740C54F154E55F847404C366D9438244740B94F15DA5FF84740BFEE012C69244740FB4F15AE22F847407828E942BC244740	0	4.64732431475541136e-05	0.0384172517946355443	\N	\N	\N
13	1	ТОС "Сун-Ят-Сена"		\N	0103000000010000003500000068446324D70A484092CC722D6F2D4740B94D6328970A4840A891EA25702D4740494F63808A0A48402BFC2FF1762D4740AA5B636C350A4840F4D61593722D4740055D63942B0A4840996957CF6A2D4740865D635C270A4840996957CF6A2D4740DB5F6330170A4840F0DAC4385D2D4740F465631CEF09484015B1F165572D4740AA666314E8094840E1035D8B942D4740307263A098094840E049AB16932D47406E77632C76094840A905FAFF4A2E47409A5A63DC3D0A484060D8BC33652E47409C5063C4820A48408FB9FC7A6C2E4740394C63989F0A4840E0AE8C41842E47400E37638C320B48406CBAB050822E4740CC3A6388180B48403A402038542E474016456338D20A48404000F0D63F2E474014426350E70A4840CE549DAFF22D47403D2D63C0760B484036C11A64FC2D4740B42963F48D0B4840BD02BD1CF52D4740EE256314AA0B4840F9AE76E4EB2D4740E5226310BD0B484025761CFBE82D4740632163B8C90B48401A79350AE72D4740891F6390D30B48401B3F2DACE22D47402E1E6368DD0B4840EF65EAD1DD2D47409E1B6348EE0B48401FAB6C7BD82D4740701A636CF70B4840D0A4792CD22D47406E1963DCFF0B48409E94C90AC62D47409318637C050C484017B14E65BA2D47403A1863E4060C48400D99093CAF2D4740BA1863AC020C4840CAE4FA8EA42D47409B196328FF0B484008455EDA9A2D4740F61A6350F50B48407907709A922D4740F81B63E0EC0B4840AE9AE3438D2D4740CC1D63ECE00B4840E519F6528B2D4740891F6390D30B4840D63B7A0B842D47408A2163E8C60B4840586DFCC37C2D4740BE2263E0BF0B48405ABC6B6D772D47409A2463D0B10B4840C939F474762D47409C256360A90B4840271A0584742D4740A326630CA30B4840271A0584742D4740A4286364960B48401A56CFC76B2D4740002A638C8C0B48401968B369672D4740632C63607C0B4840898B1E13622D4740F42F6310630B48400E1001B55D2D4740573263E4520B48403DE2E256592D4740853363C0490B48403F5C0075552D4740E03463E83F0B4840D3DCE016512D4740B43663F4330B4840BDA839B14D2D4740433863842B0B4840CE59DCD6482D47409D446354D40A4840C08A2BA24F2D47409D446354D40A48400E1001B55D2D474068446324D70A484092CC722D6F2D4740	0	0.000117511387179181897	0.0586717632589066965	\N	\N	\N
14	1	ТОС "Микрорайон"		\N	0103000000010000001600000093898625E1FD47408713EDCDD0344740708906A2D5FD4740A627C9BEC63447408C890619C8FD4740FACB6242CE344740668A86B96BFD47402A1D43B97F344740148A867A50FD4740DFB8F63568344740568A86E54EFD474010A05B8B653447402C8A86A750FD4740FF98E37B63344740238A86415CFD4740D7DB8FAA5D344740FC89861D80FD4740BC5CEF8B493447403D8A86D9B4FD4740E6843AD22C344740138A86E0CBFD4740C132896D21344740228A866EE3FD47403E976E9418344740088A8679E7FD47405E9849F917344740DF898681EEFD4740D95CA26D193447401A8A861500FE474077EBF5001F344740CF89868922FE4740759283082E344740E789860849FE47407BC1E4743C3447409F8986968DFE4740333A503658344740A88986F060FE4740655BF7DF82344740EB8986DD55FE47409BEED33C8B344740EB8986D134FE47408B285FD79F34474093898625E1FD47408713EDCDD0344740	0	3.01237686659981305e-05	0.0229706486131427412	\N	\N	\N
15	1	ТОС "Бумажник-1"		\N	0103000000010000000E0000008088C00397FC4740A2322E4AEE3547406188C093E8FC47405E4FE119043647405D88C03FE2FC4740D922195F0B364740B587C0E7FCFD47407CF0EBDB5A3647406B87C0F34AFE47401F2DF08E543647405A87C0EF5DFE4740A36AA29E523647405A87C0CBAEFE4740F2741470F9354740F886C04FB2FE47401B88A14CCE3547401388C04B30FD4740380A8D6A6B3547402588C00BF8FC4740B9221F7B593547404A88C0A3C9FC4740E5348ABD903547406188C0B797FC4740BB6FEED5EC3547408088C00397FC4740C1B20352ED3547408088C00397FC4740A2322E4AEE354740	0	7.64609406789488078e-05	0.0392148810926411864	\N	\N	\N
16	1	ТОС "Жилгородок"		\N	010300000001000000190000007D84FE12B5024840DF670BB5772B4740D383FEFEF4034840A83EC867922B47401483FE6EDE044840A2AAA35DA42B47403583FE46E804484094A412BF652B47404383FE8EFA044840644EDD12E62A47402583FE42FB044840569DADA7D22A47402583FE42FB0448406106AB95B32A47406083FECAEB04484041C4CF99912A47400683FE32ED044840E7B4280D612A47406083FEEE9A044840E7B4280D612A47404A83FEFE7B044840C37B7289612A47407183FE1637044840B1524B985F2A47408F83FE6236044840193637A56E2A4740BC83FEAE35044840B4C0CE69762A4740DF83FE72EA034840D5AAED286E2A47400A84FEEACC034840193637A56E2A47402984FE5A7B0348403C64C06B652A47402F84FEA64D034840E7B4280D612A47400484FE1629034840CDB0B79F5E2A47400484FE1629034840E06CCF5E562A47404284FE5AF402484063765DF1532A47404C84FE42DF02484085C82E9A4E2A47401D84FE2EE40248402DEE3B71752A47402784FEDADD02484096F902E0A92A47407D84FE12B5024840DF670BB5772B4740	0	0.000152187259150581038	0.0532043526380820211	\N	\N	\N
17	1	ТОС "Форпост"		\N	0103000000010000002000000096D772D6040148401CA1629F302F474062D772EC0C01484083FE44F42D2F4740C2D772DCFE0048400C21CB78042F474081D772FC1A0148405E27CE6FFD2E474068D772080F01484080B052E6DD2E47404DD77234790148403A08C065C52E47404DD772644901484039782A6A622E474048D7728E4C0148405D911EC03E2E474031D7721C370148409247E09D092E474099D772F0260148406627B5F5CC2D47408ED772F206014840A95346A98C2D474092D77276DD0048405FB2543A402D4740C1D7727EB7004840805A96EE072D4740FAD772287700484081590613C12C474039D87258EDFF47406863E986FC2C47401CD872BEB4FF47409217F7CA142D47406AD8724C72FF4740EB90068F3D2D47408AD8720226FF4740CD2A8527742D4740A7D8725659FF4740D598C4127F2D474026D8726AAEFF47401B1855769B2D474096D8722EBDFF474084189970A42D474078D8721EAFFF47408B19B4FDAA2D474014D872F0EBFF47402F23354CD22D47405BD872821D004840279353C50C2E474015D8724E33004840098C31482D2E47403CD872423F004840C600C4EA512E474037D8726C42004840E7223B00702E474003D872824A0048400ECF0714862E4740CCD7728A510048402AF77D73922E4740BAD772108F00484054790FBCCA2E47406BD7725201014840B1EB92AE2E2F474096D772D6040148401CA1629F302F4740	0	0.000146331961294506079	0.0581219998103394975	\N	\N	\N
19	1	ТОС "Юго-Восточный"		\N	0103000000010000001700000059D46EC4CA06484053B28B25742B47401BD46E2ED906484030083C6B5A2B4740C0D36E20050748402CF07F954C2B47407DD36ED66C074840439FDC4F662B47409ED36EDCED074840637A5C258D2B4740B7D26E90CF0848408BB6ADA5CF2B4740EDD26E12F3084840B4996FBED42B474036D26E50A50948401DA6C514F32B474042D26ED0BB0948404D28EE3B712B474089D26E869C094840CBA6AC6D302B4740A0D26E1C61094840E7E7AD60EF2A4740B0D26EC206094840370FE82DB32A4740FAD26EFCBD08484004D3789F932A47408BD36EEEAE07484014B82A0F422A474097D36E56830748404BFEB466A32A474034D46EB048064840FA994EE09B2A474085D46E1E440648406F09561DDF2A474053D46E9CA70648407AE5974CE12A47404DD46E80A5064840380F7D45FB2A474036D46E549506484009AB03F1FD2A474083D46E26780648403FF66325102B474067D46E246B064840C768F8E9622B474059D46EC4CA06484053B28B25742B4740	0	0.000197957195767501862	0.0725715202628236661	\N	\N	\N
20	1	ТОС "Добрых дел"		\N	0103000000010000001A0000009FF0AF632D0B4840769E88BDB4344740ACD3AFC7F50B4840816D744A8B3447401DD3AFFFF90B4840541763351E34474072DDAFA1B20B4840C0CAAC6B1F344740FEDDAF5BAD0B48409C4E292EBF33474005DFAF07A70B48402B54C9DE2833474067EDAF4B450B4840F92EA5052C3347404DF3AFCF1B0B4840D1D0C0C733334740FCFDAF09D30A4840F8B2A2994933474021FDAFA9D80A4840F565536B573347404EFDAFF5D70A4840A2D3B6C86B334740C3FBAF73E10A4840DD467F9A8933474046FAAFF1EA0A484096CFBF35963347401CFAAFB3EC0A4840CAAF951EA933474073FAAF3DEA0A4840D3900BB2C63347403EFAAF0DED0A484019152E260034474014F9AF07F30A4840E2CD86B90534474043EFAF3B370B4840EF70FEA90734474093EEAF193B0B4840DE3431FF1434474067EDAF4B450B4840F5FAE2E7173447400EEFAF0B3A0B484037C691E72F34474076F2AF7D220B4840176BCBEE4E344740F9F2AF531F0B4840965863C76B344740A2F2AFC9210B48409828C1238834474044F1AF932A0B484005D36D70A63447409FF0AF632D0B4840769E88BDB4344740	0	6.72191464888224368e-05	0.0398708286869072295	\N	\N	\N
43	2	№5	\N	\N	0101000000FEFF7F0528FE4740DC2C1FBD462D4740	0	0	0	2020-03-19 10:25:00	2020-03-19 10:25:11	\N
42	3	11	\N	\N	0101000000FEFFBFC905FE47407858D2D7442D4740	0	0	0	2020-03-19 10:19:57	2020-03-19 10:20:09	\N
41	3	11	\N	\N	0101000000FFFFBF4412FE47409872F5C94B2D4740	0	0	0	2020-03-19 10:19:45	2020-03-19 10:20:22	\N
46	3	11	\N	\N	0101000000FFFFFFDD29FE4740B4E6F7AF502D4740	0	0	0	2020-03-19 10:25:40	2020-04-27 12:19:28	\N
38	7	ТП 1096	\N	\N	0101000000FFFFFF9931FE474000997CB23A2D4740	0	0	0	2020-03-16 11:27:43	2020-03-16 11:28:42	\N
32	2	№6	\N	\N	0101000000FFFF7F6A2CFE474098CD0E45372D4740	0	0	0	2020-03-13 06:23:30	2020-03-19 10:08:21	\N
48	3	11	\N	\N	01010000000000804029FE4740A805109E462D4740	0	0	0	2020-03-19 10:25:52	2020-04-27 12:19:31	\N
37	3	11	\N	\N	0101000000000000FD28FE4740B8FA1C9E362D4740	0	0	0	2020-03-13 06:27:35	2020-03-19 10:15:27	\N
31	2	№7	\N	\N	0101000000FFFFFF4828FE47403CD886F3362D4740	0	0	0	2020-03-13 06:23:28	2020-03-19 10:15:30	\N
40	3	11	\N	\N	0101000000FFFFFF4E22FE474044705E174B2D4740	0	0	0	2020-03-19 10:18:11	2020-03-19 10:18:28	\N
39	3	11	\N	\N	0101000000FFFFFF511FFE4740A466AA364C2D4740	0	0	0	2020-03-19 10:17:53	2020-03-19 10:18:38	\N
3	1	ТОС "Бабаевского"	\N	\N	0103000000010000000C000000C37DDB3FCB0C4840E5C1661A71344740A57DDB2FBD0C48407A279EC61B344740D87DDBC78E0C4840FF8245521A3447409F7D199F810C4840FDB41101223347409C7DB880230C4840A6C507E124334740F37DB8DCA90B48406B677C362A334740A27D57BBA80B48403CE723466F3347409D7D57E5AB0B484029F7B700983347406B7D57C3AF0B4840372BC49B04344740657D57C9030C4840CFED2C4E06344740147D5737590C4840F24CE88986344740C37DDB3FCB0C4840E5C1661A71344740	0	6.17851133310693204e-05	0.035713042060121776	\N	2019-09-27 05:21:30	\N
18	1	ТОС "Вороний бугор"	\N	\N	01030000000100000013000000DDD2113EFA084840809CD3C998304740DAD11106B80A484055D917B2193047401ED211A2760A484083479D97CB2F47404BD211E2540A484048043AF8AE2F47405BD2110AF1094840B376EDF56D2F474041D311FA20084840B091C97A462E474060D3113AFF074840909A5F83242E4740C4D311AEC7074840003EEE8A232E4740C6D3116AA20748404DE6955D292E4740DBD311FE860748400E6DD54A8E2E47401CD411A2790748404B46D7C3D02E474075D3CFA574074840AC002933182F47408BD36EE28D074840FCF7CA206B2F47405AD36E12B8074840ECBD0E869F2F47405BD36E340E084840DAF99AFDE92F47403FD36E1A730848403529B1DA3F304740FFD26E8CB508484092F1291879304740C7D26E64EC08484077C2586997304740DDD2113EFA084840809CD3C998304740	0	0.000251680212672687731	0.0680141716089472659	\N	2019-09-27 05:21:41	\N
30	2	№1	\N	\N	01010000000000807D37FE4740388659D8362D4740	0	0	0	2020-03-13 06:23:14	2020-03-16 11:38:36	\N
22	2	№3	\N	\N	01010000000000008E3DFE47401445908A562D4740	0	0	0	2019-09-05 04:38:38	2020-03-19 10:23:53	25
36	3	11	\N	\N	01010000000000005D23FE4740DC95BED23F2D4740	0	0	0	2020-03-13 06:27:23	2020-04-27 12:19:34	\N
52	2	2-2	\N	\N	0101000000000000D047FD47407822CDD11B2D4740	0	0	0	2020-04-27 05:42:46	2020-04-27 05:42:55	\N
25	2	№10	\N	\N	01010000000100000206FE4740E839D18D432D4740	0	0	0	2019-09-05 04:39:05	2020-03-19 10:19:20	21
34	3	11	\N	\N	01010000000000C0D436FE4740988FD186362D4740	0	0	0	2020-03-13 06:26:43	2020-03-19 10:13:58	\N
35	3	11	\N	\N	01010000000100C00F38FE4740F855C267362D4740	0	0	0	2020-03-13 06:26:48	2020-03-19 10:13:59	\N
21	2	№11	\N	\N	0101000000FFFFFF4F12FE4740100240974A2D4740	0	0	0	2019-09-05 04:38:30	2020-03-19 10:19:29	24
29	6	ПП	\N	\N	01010000000000807D37FE4740300C1F2A382D4740	0	0	0	2020-03-02 07:24:37	2020-03-19 10:14:03	\N
26	2	№4	\N	\N	01010000000000008429FE47402C5606434F2D4740	0	0	0	2019-09-05 04:39:14	2020-03-19 10:24:15	22
28	2	№8	\N	\N	0101000000FFFF7F3822FE474034CF27A43F2D4740	0	0	0	2019-09-29 16:39:56	2020-03-19 10:24:53	23
47	3	11	\N	\N	0101000000FFFF7F9D26FE4740A805109E462D4740	0	0	0	2020-03-19 10:25:46	2020-04-27 12:19:32	\N
44	3	11	\N	\N	0101000000FEFFFF223FFE4740D4B6F15F462D4740	0	0	0	2020-03-19 10:25:29	2020-03-19 10:25:59	\N
45	3	11	\N	\N	0101000000FEFFFF8D3DFE4740FCA7901E592D4740	0	0	0	2020-03-19 10:25:35	2020-03-19 10:26:16	\N
50	2	2-1	\N	\N	0101000000000000045FFD4740AC9F8B77272D4740	0	0	0	2020-04-25 07:10:53	2020-04-27 05:42:43	\N
33	3	11	\N	\N	0101000000010090782CFE4740347277B3362D4740	0	0	0	2020-03-13 06:26:11	2020-03-20 12:36:04	\N
53	2	2-3	\N	\N	0101000000FFFFFFB732FD4740E04147A8102D4740	0	0	0	2020-04-27 05:42:58	2020-04-27 05:43:05	\N
51	2	2-5	\N	\N	0101000000FEFFFFCF7C044840D89EBA77692D4740	0	0	0	2020-04-27 05:03:09	2020-04-27 05:24:13	\N
54	7	ТП2	\N	\N	01010000000000009C8AFD4740C81DE3422E2D4740	0	0	0	2020-04-27 05:44:03	2020-04-27 05:44:17	\N
55	3	2-1-1	\N	\N	0101000000FFFFFF0959FD474010315D3B2F2D4740	0	0	0	2020-04-27 05:57:02	2020-04-27 05:57:14	\N
56	3	2-1-2	\N	\N	0101000000000000F063FD474014A1C0D3232D4740	0	0	0	2020-04-27 05:57:17	2020-04-27 05:57:25	\N
57	6	ПП3	\N	\N	010100000000000038D0FD474068D4E16B372D4740	0	0	0	2020-04-27 12:09:06	2020-04-27 12:14:52	\N
58	2	3-1	\N	\N	010100000000000014C7FD4740005E3A16362D4740	0	0	0	2020-04-27 12:12:57	2020-04-27 12:13:52	\N
59	2	3-2	\N	\N	010100000000000077BEFD4740405A4005302D4740	0	0	0	2020-04-27 12:14:58	2020-04-27 12:15:09	\N
60	3	3-2-1	\N	\N	01010000000100002BBFFD4740DC0DA9942F2D4740	0	0	0	2020-04-27 12:15:32	2020-04-27 12:17:30	\N
23	2	№22	\N	\N	0101000000000000803CFE474028A8C486462D4740	0	0	0	2019-09-05 04:38:52	2020-04-27 12:19:20	\N
49	6	ПП2	\N	\N	0101000000010000100AFB474060CB4F2B902D4740	0	0	0	2020-04-25 07:06:53	2020-04-27 18:45:48	\N
61	2	3-3	\N	\N	0101000000FFFFFFA75904484000E6533D792D4740	0	0	0	2020-04-27 12:27:45	2020-04-27 12:28:06	\N
66	8	Каскад 1	\N	\N	\N	\N	\N	\N	2020-04-27 19:12:19	2020-04-27 19:12:37	\N
68	7	ТП № 283	\N	\N	0101000000000000041B0548404C648A34132D4740	0	0	0	2020-04-27 19:18:06	2020-04-27 19:18:35	\N
69	6	Новый элемент	\N	\N	0101000000FDFFFFB71B0548400CEAC7B0132D4740	0	0	0	2020-04-27 19:24:51	2020-04-27 19:27:11	\N
24	2	№9	\N	\N	010200000003000000030000AC1FFE4740FC8B7C134B2D4740CE79CCC227FE474054E5ABCC492D4740050000803CFE474024A8C486462D4740	0.000890653511314973907	0	0	2019-09-05 04:38:59	2020-04-30 09:23:38	23
73	6	Новый элемент	\N	\N	\N	\N	\N	\N	2020-05-09 07:47:15	2020-05-09 07:47:15	\N
\.


--
-- Name: geo_elements_id_seq; Type: SEQUENCE SET; Schema: public; Owner: smartcity
--

SELECT pg_catalog.setval('public.geo_elements_id_seq', 73, true);


--
-- Data for Name: geo_layers; Type: TABLE DATA; Schema: public; Owner: smartcity
--

COPY public.geo_layers (id, alias, title, description, parent_id, module_id, visibility, geometry_type, style, created_at, updated_at) FROM stdin;
6	pitayushchiye-punkty	Питающие пункты	\N	\N	2	t	point	{"id":1,"showTitle":true,"shape":{"points":"4","fill":{"color":"#009fe3","opacity":0},"stroke":{"color":"#164194","width":1,"opacity":0},"radius":"16","rotation":0.7853981633974483},"icon":{"src":"http://api.city-panorama.ru/storage/images/layers/u07pCr2a1BlJa4gvwoDEi0RnWfooJg6CyJ3eRkiG.jpeg","anchor":[24,24],"opacity":0,"scale":1,"rotation":0},"pointType":"icon","font":{"font":"16px Calibri, sans-serif","textBaseline":"bottom","offsetY":-6,"fill":{"color":"#000000"},"stroke":{"color":"#ffffff","width":3}},"list":{"hasList":false,"visibility":false,"color":"#000000","opacity":0}}	2020-03-02 07:17:12	2020-04-27 19:38:12
1	tos	ТОСы	\N	\N	1	t	polygon	{"id":1,"showTitle":true,"fill":{"color":"#ff7845","opacity":50},"stroke":{"color":"#e4352b","width":1},"font":{"font":"16px Calibri, sans-serif","fill":{"color":"#000000"},"stroke":{"color":"#ffffff","width":3},"textBaseline":"bottom","offsetY":-6}}	\N	2020-04-27 05:56:35
5	zahoronenija	Захоронения	\N	\N	3	t	polygon	{"id":1,"showTitle":true,"fill":{"color":"#009fe3","opacity":50},"stroke":{"color":"#164194","width":1},"font":{"font":"16px Calibri, sans-serif","fill":{"color":"#000000"},"stroke":{"color":"#ffffff","width":3},"textBaseline":"bottom","offsetY":-6}}	\N	2020-04-27 05:56:38
4	kladbishha	Кладбища	\N	\N	3	t	polygon	{"id":1,"showTitle":true,"fill":{"color":"#7a9700","opacity":50},"stroke":{"color":"#011c00","width":1},"font":{"font":"16px Calibri, sans-serif","fill":{"color":"#000000"},"stroke":{"color":"#ffffff","width":3},"textBaseline":"bottom","offsetY":-6}}	\N	2020-04-27 05:56:41
3	osveshhenie	Светильники	\N	\N	2	t	point	{"id":1,"showTitle":"false","shape":{"points":66,"fill":{"color":"#F2665F"},"stroke":{"color":"#F28B86","width":1},"radius":5},"icon":{"src":"https://api.city-panorama.ru/storage/images/layer/default.png","anchor":[24,24],"opacity":0,"scale":1,"rotation":0},"pointType":"shape","font":{"font":"16px Calibri, sans-serif","fill":{"color":"#000000"},"stroke":{"color":"#ffffff","width":3},"textBaseline":"bottom","offsetY":-6},"list":{"hasList":false,"visibility":false,"color":"#000000","opacity":0}}	\N	2020-04-27 12:08:24
2	opory	Опоры	\N	\N	2	t	point	{"id":1,"showTitle":true,"shape":{"points":"4","fill":{"color":"#4FBBC5"},"stroke":{"color":"#C58A6E","width":"3"},"radius":"5"},"icon":{"src":"https://api.city-panorama.ru/storage/images/layers/XfvRfZ2h7CjMxCBxJqA1j7KPOGh7pbE6eKvTWchh.png","anchor":[12,12],"opacity":0,"scale":1,"rotation":0},"pointType":"shape","font":{"font":"16px Calibri, sans-serif","fill":{"color":"#000000"},"stroke":{"color":"#ffffff","width":3},"textBaseline":"bottom","offsetY":-6},"list":{"hasList":"false","visibility":"false","color":"#BE6969","opacity":"50"}}	\N	2020-04-27 05:56:27
8	kaskad	Каскады	\N	\N	2	t	polygon	{"id":1,"showTitle":true,"fill":{"color":"#009fe3","opacity":20},"stroke":{"color":"#164194","width":1,"opacity":0},"font":{"font":"16px Calibri, sans-serif","textBaseline":"bottom","offsetY":-6,"fill":{"color":"#000000"},"stroke":{"color":"#ffffff","width":3}}}	2020-04-27 18:35:41	2020-04-27 18:35:41
7	tp	Трансформаторные подстанции	\N	\N	2	t	point	{"id":1,"showTitle":true,"shape":{"points":"4","fill":{"color":"#F4CFF6","opacity":0},"stroke":{"color":"#FF0000","width":1,"opacity":0},"radius":"20","rotation":0.7853981633974483},"icon":{"src":"http://api.city-panorama.ru/storage/images/layer/default.png","anchor":[24,24],"opacity":0,"scale":1,"rotation":0},"pointType":"shape","font":{"font":"16px Calibri, sans-serif","textBaseline":"bottom","offsetY":-6,"fill":{"color":"#000000"},"stroke":{"color":"#ffffff","width":3}},"list":{"hasList":false,"visibility":false,"color":"#000000","opacity":0}}	2020-03-16 11:20:53	2020-04-27 18:41:19
\.


--
-- Name: geo_layers_id_seq; Type: SEQUENCE SET; Schema: public; Owner: smartcity
--

SELECT pg_catalog.setval('public.geo_layers_id_seq', 8, true);


--
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: smartcity
--

COPY public.migrations (id, migration, batch) FROM stdin;
36	2014_10_12_000000_create_address_table	1
37	2014_10_12_100000_create_contractors_table	1
38	2014_10_12_200000_create_users_table	1
39	2014_10_12_300000_create_password_resets_table	1
40	2016_06_01_000001_create_oauth_auth_codes_table	1
41	2016_06_01_000002_create_oauth_access_tokens_table	1
42	2016_06_01_000003_create_oauth_refresh_tokens_table	1
43	2016_06_01_000004_create_oauth_clients_table	1
44	2016_06_01_000005_create_oauth_personal_access_clients_table	1
45	2018_12_14_072003_create_modules_table	1
46	2018_12_14_072027_create_privileges_table	1
47	2018_12_14_072117_create_geo_layers_table	1
48	2018_12_14_072158_create_geo_elements_table	1
49	2018_12_23_161856_create_triggers_for_geo	1
50	2019_06_10_071242_create_constructor_metadata_table	1
51	2019_08_19_181157_alter_constructor_metadata_table_add_enums_column	1
52	2019_08_29_124939_update_constructor_metadata_table_add_group_column	1
53	2019_09_03_124924_update_geo_elements_table_add_prev_next	1
54	2019_09_05_112915_update_constructor_metadata_table_add_state	2
55	2020_01_24_080048_update_users_table_add_role	3
56	2020_02_13_144730_update_constructor_metadata_table_add_options_column	3
\.


--
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: smartcity
--

SELECT pg_catalog.setval('public.migrations_id_seq', 56, true);


--
-- Data for Name: modules; Type: TABLE DATA; Schema: public; Owner: smartcity
--

COPY public.modules (id, title, description, created_at, updated_at) FROM stdin;
1	ТОСы	Информация о территориально-общественных самоупралениях	\N	\N
3	Кладбища	Информация о кладбищах и захоронениях	\N	\N
2	Уличное освещение	<p>Информация о системе уличного освещения МО "Город Астрахань"</p>	\N	2020-04-27 17:36:45
\.


--
-- Name: modules_id_seq; Type: SEQUENCE SET; Schema: public; Owner: smartcity
--

SELECT pg_catalog.setval('public.modules_id_seq', 3, true);


--
-- Data for Name: oauth_access_tokens; Type: TABLE DATA; Schema: public; Owner: smartcity
--

COPY public.oauth_access_tokens (id, user_id, client_id, name, scopes, revoked, created_at, updated_at, expires_at) FROM stdin;
4f5c52c9bae0086d10851c2e198bf34f02cbd21604f65a168600b21c85ca80b4200ffd3ce58ac2c8	1	3	Personal Access Token	[]	f	2020-05-09 15:06:35	2020-05-09 15:06:35	2021-05-09 15:06:35
5cf77e65dc824f688fe16581892a921cc1f2904e76c7caaa892af5aa06c8b96fb3ce6726679d9c66	2	1	Personal Access Token	[]	f	2019-09-05 04:37:02	2019-09-05 04:37:02	2020-09-05 04:37:02
a0371c356b13af259ead2634d8c2c94e8833cf1a753874051ef8b1cfa45b042f2613f3225e1f4e1e	2	1	Personal Access Token	[]	f	2019-09-05 04:38:12	2019-09-05 04:38:12	2020-09-05 04:38:12
75a62b7e03ad2088e965377ad60a1dbf9f3dfbdbafa6914a90b27818febd474bffee56413b8a47ba	2	1	Personal Access Token	[]	f	2019-09-05 04:42:15	2019-09-05 04:42:15	2020-09-05 04:42:15
cf41601d193db195a15cb7ffb9079d8fa9439b1bd2bf0966e6f5ab1b2eeca8a6687782597d98a5c8	2	1	Personal Access Token	[]	f	2019-09-06 09:11:50	2019-09-06 09:11:50	2020-09-06 09:11:50
5ac3ed1bb0f81234768758ed469e7974ed30070de9d03f117c1e4c095d1290ca929e2f56f8a0f0b2	2	1	Personal Access Token	[]	f	2019-09-06 09:37:39	2019-09-06 09:37:39	2020-09-06 09:37:39
1cacb54eb3ace05f12d3b6efd457b2587082bb2371727056822c71760956316327919e0cc54a4967	2	1	Personal Access Token	[]	f	2019-09-06 09:40:49	2019-09-06 09:40:49	2020-09-06 09:40:49
dab6ba6f1e2896be7d91236b9eae616fcfa18f42a05e44e8ecf9bf07174fad240383f964d8957635	3	1	Personal Access Token	[]	f	2019-09-26 20:02:10	2019-09-26 20:02:10	2020-09-26 20:02:10
6d319a3efe8a07c416d640db2d61fc7060a0875643f10da74b6914dde82d99b39f3f93a0c65b3d38	3	1	Personal Access Token	[]	f	2019-09-26 20:02:34	2019-09-26 20:02:34	2020-09-26 20:02:34
82492da85412e6fb8a278626b13b503513c6fa7b648e3c5b634ce177ec8b112eebbd861513bc7f3f	2	1	Personal Access Token	[]	f	2019-09-26 20:05:28	2019-09-26 20:05:28	2020-09-26 20:05:28
799b66a87c31410de970c78aa3e404d1595d19816353d76b3737e5d7901d9f100a200b98ad724b49	3	1	Personal Access Token	[]	f	2019-09-26 20:07:26	2019-09-26 20:07:26	2020-09-26 20:07:26
460d65741f479ba2d04a3115a4fa5ad4acffb961961a8db1aa59244a43752b54faeee64c88cf332c	3	1	Personal Access Token	[]	f	2019-09-26 20:11:29	2019-09-26 20:11:29	2020-09-26 20:11:29
3d00577dd64ae23d9fa4502537eb0047c146f22b2831b59490e11e59f79186ddecfe1fe57053a913	4	1	Personal Access Token	[]	f	2019-09-27 05:19:44	2019-09-27 05:19:44	2020-09-27 05:19:44
902d3444baecc3d6e4e87d0c07c4f76ebae3a2b6024934c02abb79336ef516fcf5a70b3a7036e61f	4	1	Personal Access Token	[]	f	2019-09-27 05:21:16	2019-09-27 05:21:16	2020-09-27 05:21:16
3cc260416a8bcff24909f615181a90dc5fe9189b91a16a27ff194a48c81c2df5d2d733a72bc60e0c	4	1	Personal Access Token	[]	f	2019-09-27 05:25:06	2019-09-27 05:25:06	2020-09-27 05:25:06
f35915ab9908a29a98edc85d817eea1f794f049543ee237ca86dc9096487b038aa001b153777ec8a	3	1	Personal Access Token	[]	f	2019-09-27 06:41:26	2019-09-27 06:41:26	2020-09-27 06:41:26
7fae0e26af913a8d67ff921ba34c3d8382b3be20eb6b18c03d415afc576d8d37536299595fafa12a	3	1	Personal Access Token	[]	f	2019-09-27 07:09:29	2019-09-27 07:09:29	2020-09-27 07:09:29
b1602cc10a9ef08728e78ed52861624c9f1b621b8cf889df511f55cf948bc8b58c82f9b221359fcc	4	1	Personal Access Token	[]	f	2019-09-27 10:14:35	2019-09-27 10:14:35	2020-09-27 10:14:35
27fd2c72dce1bf75365df9cf74d27c12564374a1232a9add7ca9e7354782d8e96840371326c255c4	4	1	Personal Access Token	[]	f	2019-09-27 10:16:33	2019-09-27 10:16:33	2020-09-27 10:16:33
8de208498070216a14c18cd744bc20faec0f737eeb1ffa53b8ece8b535f453992e502f6bdf1474a0	5	3	Personal Access Token	[]	f	2020-03-20 09:56:06	2020-03-20 09:56:06	2021-03-20 09:56:06
14d440eada8b2ad54c0c7be52b2c529338394c0594cac641d48c674cf2769f35a496e71901de814c	4	1	Personal Access Token	[]	f	2019-09-27 10:17:17	2019-09-27 10:17:17	2020-09-27 10:17:17
370b462e2a538521a3daafce5044276522ce257a7112e1e354f51c16e0f149ad354a885ad6932c89	3	1	Personal Access Token	[]	f	2019-09-29 10:37:38	2019-09-29 10:37:38	2020-09-29 10:37:38
094cdb7d9d47b3b923ac64db7be4f084062a6c9f80059cc52b4716631f8e031e347c0a13482a8f23	3	1	Personal Access Token	[]	f	2019-09-29 11:26:13	2019-09-29 11:26:13	2020-09-29 11:26:13
d5b03c86b50c9823b4cec6296c00f2f93ae57238c3f98de089e6cae52fa90125d7855299072cbf85	3	1	Personal Access Token	[]	f	2019-09-29 16:38:24	2019-09-29 16:38:24	2020-09-29 16:38:24
475869f468248f39ca206a786e8dd2258ffd937004dfa8f9bb63fb12f763b7eab168c92ae281f9a9	3	1	Personal Access Token	[]	f	2019-09-30 18:32:43	2019-09-30 18:32:43	2020-09-30 18:32:43
c978b7423bdde5c0382527f46b0077a719394592dbb612b949fd702617ff8c4a8d46089bd1753ab5	3	1	Personal Access Token	[]	f	2019-10-01 06:39:33	2019-10-01 06:39:33	2020-10-01 06:39:33
d3c4e79713e8c8f5557e9cd49ad7d6d5bb2e8f8d071ce38fcea8f9ae0c1155825ae308e403f78d0f	3	1	Personal Access Token	[]	f	2019-10-08 07:16:42	2019-10-08 07:16:42	2020-10-08 07:16:42
d09b85fbc14edbcdd63fb5e8b7248be1356439205d987ba506feaddc2f5d2d79240a373a1841cc81	5	3	Personal Access Token	[]	f	2020-04-27 18:50:41	2020-04-27 18:50:41	2021-04-27 18:50:41
\.


--
-- Data for Name: oauth_auth_codes; Type: TABLE DATA; Schema: public; Owner: smartcity
--

COPY public.oauth_auth_codes (id, user_id, client_id, scopes, revoked, expires_at) FROM stdin;
\.


--
-- Data for Name: oauth_clients; Type: TABLE DATA; Schema: public; Owner: smartcity
--

COPY public.oauth_clients (id, user_id, name, secret, redirect, personal_access_client, password_client, revoked, created_at, updated_at) FROM stdin;
1	\N	SmartCityApi Personal Access Client	5ih6z9KWuWqfOmhR48kxgdtz82tM90YzNKpZl7jL	http://localhost	t	f	f	2019-09-04 15:55:52	2019-09-04 15:55:52
2	\N	SmartCityApi Password Grant Client	sOvGjMsVHsGIHgSWftzQ9RUon3Danx7hsEsKk5RV	http://localhost	f	t	f	2019-09-04 15:55:52	2019-09-04 15:55:52
3	\N	SmartCityApi Personal Access Client	XagwaDWdLxizbP0lWC2pZIQVJmPPbravrSXm4ceZ	http://localhost	t	f	f	2020-02-20 07:58:33	2020-02-20 07:58:33
4	\N	SmartCityApi Password Grant Client	2YKXVraD9Yj2w6r0G2n1Aw5LvvAu9QCznBxjVRzq	http://localhost	f	t	f	2020-02-20 07:58:33	2020-02-20 07:58:33
\.


--
-- Name: oauth_clients_id_seq; Type: SEQUENCE SET; Schema: public; Owner: smartcity
--

SELECT pg_catalog.setval('public.oauth_clients_id_seq', 4, true);


--
-- Data for Name: oauth_personal_access_clients; Type: TABLE DATA; Schema: public; Owner: smartcity
--

COPY public.oauth_personal_access_clients (id, client_id, created_at, updated_at) FROM stdin;
1	1	2019-09-04 15:55:52	2019-09-04 15:55:52
2	3	2020-02-20 07:58:33	2020-02-20 07:58:33
\.


--
-- Name: oauth_personal_access_clients_id_seq; Type: SEQUENCE SET; Schema: public; Owner: smartcity
--

SELECT pg_catalog.setval('public.oauth_personal_access_clients_id_seq', 2, true);


--
-- Data for Name: oauth_refresh_tokens; Type: TABLE DATA; Schema: public; Owner: smartcity
--

COPY public.oauth_refresh_tokens (id, access_token_id, revoked, expires_at) FROM stdin;
\.


--
-- Data for Name: password_resets; Type: TABLE DATA; Schema: public; Owner: smartcity
--

COPY public.password_resets (email, token, created_at) FROM stdin;
\.


--
-- Data for Name: privileges; Type: TABLE DATA; Schema: public; Owner: smartcity
--

COPY public.privileges (id, contractor_id, module_id, created_at, updated_at) FROM stdin;
1	2	1	\N	\N
2	2	2	\N	\N
3	2	3	\N	\N
5	4	1	\N	\N
6	4	2	\N	\N
7	4	3	\N	\N
8	1	1	\N	\N
9	1	2	\N	\N
10	1	3	\N	\N
11	5	2	\N	\N
\.


--
-- Name: privileges_id_seq; Type: SEQUENCE SET; Schema: public; Owner: smartcity
--

SELECT pg_catalog.setval('public.privileges_id_seq', 11, true);


--
-- Data for Name: spatial_ref_sys; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.spatial_ref_sys (srid, auth_name, auth_srid, srtext, proj4text) FROM stdin;
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: smartcity
--

COPY public.users (id, name, email, email_verified_at, password, contractor_id, remember_token, created_at, updated_at, role) FROM stdin;
3	lieber1882@mail.ru	lieber1882@mail.ru	\N	$2y$10$m9EGvsoh7XwDyT6I/Epcn.yRriYht./WhLj4R72XuSVQdcK0.TghW	4	\N	2019-09-26 20:01:07	2019-09-26 20:01:07	admin
2	user@user.ru	user@user.ru	\N	$2y$10$403cR/C5ZgBPFzAR./Y5xOx8Vdg.ZzLMj2TZs9nI4.qd5b2sx4Y4e	2	\N	\N	2019-09-26 20:05:05	admin
4	il-kow@mail.ru	il-kow@mail.ru	\N	$2y$10$wtWgyiRsDpEG5qIuI5wqOeQmO1PloE.wIHfeT.0r4.b1HnX9GzDFu	2	\N	2019-09-27 05:19:27	2019-09-27 05:19:27	admin
1	admin	admin@admin.ru	\N	$2y$10$wpykVVvmViUdDG1fDPYMQe4DU/CNBPXUZ8d8KRhQZiGAh52EajKma	1	\N	\N	\N	superadmin
5	admin@gorsvet.ru	admin@gorsvet.ru	\N	$2y$10$Z9cTzA16/HILP2p1mmtuqeSkUREsatILazzkqQ9rDu3C9DpBSPd2e	5	\N	2020-03-02 06:58:44	2020-04-27 18:08:12	admin
\.


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: smartcity
--

SELECT pg_catalog.setval('public.users_id_seq', 5, true);


--
-- Data for Name: topology; Type: TABLE DATA; Schema: topology; Owner: postgres
--

COPY topology.topology (id, name, srid, "precision", hasz) FROM stdin;
\.


--
-- Data for Name: layer; Type: TABLE DATA; Schema: topology; Owner: postgres
--

COPY topology.layer (topology_id, layer_id, schema_name, table_name, feature_column, feature_type, level, child_id) FROM stdin;
\.


--
-- Name: address address_pkey; Type: CONSTRAINT; Schema: public; Owner: smartcity
--

ALTER TABLE ONLY public.address
    ADD CONSTRAINT address_pkey PRIMARY KEY (id);


--
-- Name: constructor_metadata constructor_metadata_pkey; Type: CONSTRAINT; Schema: public; Owner: smartcity
--

ALTER TABLE ONLY public.constructor_metadata
    ADD CONSTRAINT constructor_metadata_pkey PRIMARY KEY (id);


--
-- Name: contractors contractors_pkey; Type: CONSTRAINT; Schema: public; Owner: smartcity
--

ALTER TABLE ONLY public.contractors
    ADD CONSTRAINT contractors_pkey PRIMARY KEY (id);


--
-- Name: geo_elements geo_elements_pkey; Type: CONSTRAINT; Schema: public; Owner: smartcity
--

ALTER TABLE ONLY public.geo_elements
    ADD CONSTRAINT geo_elements_pkey PRIMARY KEY (id);


--
-- Name: geo_layers geo_layers_pkey; Type: CONSTRAINT; Schema: public; Owner: smartcity
--

ALTER TABLE ONLY public.geo_layers
    ADD CONSTRAINT geo_layers_pkey PRIMARY KEY (id);


--
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: smartcity
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- Name: modules modules_pkey; Type: CONSTRAINT; Schema: public; Owner: smartcity
--

ALTER TABLE ONLY public.modules
    ADD CONSTRAINT modules_pkey PRIMARY KEY (id);


--
-- Name: oauth_access_tokens oauth_access_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: smartcity
--

ALTER TABLE ONLY public.oauth_access_tokens
    ADD CONSTRAINT oauth_access_tokens_pkey PRIMARY KEY (id);


--
-- Name: oauth_auth_codes oauth_auth_codes_pkey; Type: CONSTRAINT; Schema: public; Owner: smartcity
--

ALTER TABLE ONLY public.oauth_auth_codes
    ADD CONSTRAINT oauth_auth_codes_pkey PRIMARY KEY (id);


--
-- Name: oauth_clients oauth_clients_pkey; Type: CONSTRAINT; Schema: public; Owner: smartcity
--

ALTER TABLE ONLY public.oauth_clients
    ADD CONSTRAINT oauth_clients_pkey PRIMARY KEY (id);


--
-- Name: oauth_personal_access_clients oauth_personal_access_clients_pkey; Type: CONSTRAINT; Schema: public; Owner: smartcity
--

ALTER TABLE ONLY public.oauth_personal_access_clients
    ADD CONSTRAINT oauth_personal_access_clients_pkey PRIMARY KEY (id);


--
-- Name: oauth_refresh_tokens oauth_refresh_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: smartcity
--

ALTER TABLE ONLY public.oauth_refresh_tokens
    ADD CONSTRAINT oauth_refresh_tokens_pkey PRIMARY KEY (id);


--
-- Name: privileges privileges_pkey; Type: CONSTRAINT; Schema: public; Owner: smartcity
--

ALTER TABLE ONLY public.privileges
    ADD CONSTRAINT privileges_pkey PRIMARY KEY (id);


--
-- Name: users users_email_unique; Type: CONSTRAINT; Schema: public; Owner: smartcity
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: smartcity
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: oauth_access_tokens_user_id_index; Type: INDEX; Schema: public; Owner: smartcity
--

CREATE INDEX oauth_access_tokens_user_id_index ON public.oauth_access_tokens USING btree (user_id);


--
-- Name: oauth_clients_user_id_index; Type: INDEX; Schema: public; Owner: smartcity
--

CREATE INDEX oauth_clients_user_id_index ON public.oauth_clients USING btree (user_id);


--
-- Name: oauth_personal_access_clients_client_id_index; Type: INDEX; Schema: public; Owner: smartcity
--

CREATE INDEX oauth_personal_access_clients_client_id_index ON public.oauth_personal_access_clients USING btree (client_id);


--
-- Name: oauth_refresh_tokens_access_token_id_index; Type: INDEX; Schema: public; Owner: smartcity
--

CREATE INDEX oauth_refresh_tokens_access_token_id_index ON public.oauth_refresh_tokens USING btree (access_token_id);


--
-- Name: password_resets_email_index; Type: INDEX; Schema: public; Owner: smartcity
--

CREATE INDEX password_resets_email_index ON public.password_resets USING btree (email);


--
-- Name: geo_elements set_geometry_properties; Type: TRIGGER; Schema: public; Owner: smartcity
--

CREATE TRIGGER set_geometry_properties BEFORE INSERT OR UPDATE ON public.geo_elements FOR EACH ROW EXECUTE PROCEDURE public.set_geometry_properties();


--
-- Name: constructed_2 constructed_2_element_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: smartcity
--

ALTER TABLE ONLY public.constructed_2
    ADD CONSTRAINT constructed_2_element_id_foreign FOREIGN KEY (element_id) REFERENCES public.geo_elements(id);


--
-- Name: constructed_3 constructed_3_element_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: smartcity
--

ALTER TABLE ONLY public.constructed_3
    ADD CONSTRAINT constructed_3_element_id_foreign FOREIGN KEY (element_id) REFERENCES public.geo_elements(id);


--
-- Name: constructed_6 constructed_6_element_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: smartcity
--

ALTER TABLE ONLY public.constructed_6
    ADD CONSTRAINT constructed_6_element_id_foreign FOREIGN KEY (element_id) REFERENCES public.geo_elements(id);


--
-- Name: contractors contractors_address_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: smartcity
--

ALTER TABLE ONLY public.contractors
    ADD CONSTRAINT contractors_address_id_foreign FOREIGN KEY (address_id) REFERENCES public.address(id);


--
-- Name: geo_elements geo_elements_address_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: smartcity
--

ALTER TABLE ONLY public.geo_elements
    ADD CONSTRAINT geo_elements_address_id_foreign FOREIGN KEY (address_id) REFERENCES public.address(id);


--
-- Name: geo_elements geo_elements_element_next_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: smartcity
--

ALTER TABLE ONLY public.geo_elements
    ADD CONSTRAINT geo_elements_element_next_id_foreign FOREIGN KEY (element_next_id) REFERENCES public.geo_elements(id);


--
-- Name: geo_elements geo_elements_layer_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: smartcity
--

ALTER TABLE ONLY public.geo_elements
    ADD CONSTRAINT geo_elements_layer_id_foreign FOREIGN KEY (layer_id) REFERENCES public.geo_layers(id);


--
-- Name: geo_layers geo_layers_module_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: smartcity
--

ALTER TABLE ONLY public.geo_layers
    ADD CONSTRAINT geo_layers_module_id_foreign FOREIGN KEY (module_id) REFERENCES public.modules(id);


--
-- Name: geo_layers geo_layers_parent_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: smartcity
--

ALTER TABLE ONLY public.geo_layers
    ADD CONSTRAINT geo_layers_parent_id_foreign FOREIGN KEY (parent_id) REFERENCES public.geo_layers(id);


--
-- Name: privileges privileges_contractor_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: smartcity
--

ALTER TABLE ONLY public.privileges
    ADD CONSTRAINT privileges_contractor_id_foreign FOREIGN KEY (contractor_id) REFERENCES public.contractors(id);


--
-- Name: privileges privileges_module_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: smartcity
--

ALTER TABLE ONLY public.privileges
    ADD CONSTRAINT privileges_module_id_foreign FOREIGN KEY (module_id) REFERENCES public.modules(id);


--
-- Name: users users_contractor_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: smartcity
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_contractor_id_foreign FOREIGN KEY (contractor_id) REFERENCES public.contractors(id);


--
-- PostgreSQL database dump complete
--

