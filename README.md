# Webová aplikace k bakalářské práci

Tato webová alikace je vyvíjena k bakalářské práci na téma "Prioritizace zákazníků při poskytování SW podpory". Aplikace slouží pro správu incidentů a výpočet jejich priorit.

# Autor

Tomáš Vyleta <br>
2019/2020 <br>
Informační Management <br>
Západočeská univerzita (ZČU)

# Společnost

Diebold Nixdorf, s.r.o. <br>
https://www.dnpilsen.cz

**Adresa:**
Diebold Nixdorf, <br>
Avalon Business Center - kancelář ve 3. patře, <br>
Poděbradova 2842/1, <br>
301 00 Plzeň - Jižní Předměstí

# Instalace

Aplikace byla vyvíjena na: <br>
* **XAMPP:** <br>
Verze: 7.2.30 <br>
Apache 2.4.43, MariaDB 10.4.11, PHP 7.2.30, phpMyAdmin 5.0.2, OpenSSL 1.1.1, XAMPP Control Panel 3.2.4, Webalizer 2.23-04, Mercury Mail Transport System 4.63, FileZilla FTP Server 0.9.41, Tomcat 7.0.103 (with mod_proxy_ajp as connector), Strawberry Perl 5.16.3.1 Portable

* **Bootstrap:** <br>
Verze: 4.4.1

## Požadavky

XAMPP - https://www.apachefriends.org/index.html

## Localhost
1. Nainstalujte a spusťte XAMPP
    * Spušťte Apache a MySQL server.
2. Vytvoření databáze
    * Pomocí XAMPPu si otevřete MySQL panel. (admin)
    * Klikněte na záložku SQL a do konzole zadejte kód ze souboru _.baka-app//sql/create_database.sql_
    * NEBO ho importujte pomocí nástroje pro import.
3. Složku (baka-app) s kódem programu zkopírujte do složky _./xampp/htdocs_
4. Program je nyní připraven k použití, avšak bez incidentů v databázi.
    * Můžete zadat/vygenerovat vlastní incidenty pomocí aplikace.
    * Můžete podle stejného postupu jako je uveden 2. bodě naplnit databázi testovacími incidenty ze souboru _./baka-app/sql/insert_test_incidents.sql_
  
# Prostředí
Uživatelskou dokumentaci lze nalézt v souboru _./baka-app/_

## Domovská stránka

## Přidání incidentu

## Tabulka s incidenty

## Kalkulace

## Koláčové grafy


Licence MIT