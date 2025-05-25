# Pjesa e Dytë (PHP Sessions, Cookies, MySQL, Pointerë, Siguri, File Handling, Email, AJAX)

---

## PHP Sessions dhe Cookies 

### 🔹 Definimi dhe përdorimi i COOKIES me të gjitha specifikat (krijim, fshirja, ruajtja në varg)
- **File**:  cardetails.php
- **Lines**:  68-81, 290-307
- **Shembull / Përshkrim**:  Cookies përdoren për të përmirësuar përvojën e përdoruesit duke i ruajtur makinat që ka shikuar së fundmi. I ruan ID-të e makinave të shikuara së fundmi. Expiration është 7 ditë. E tërë kjo bën që të paraqitet një seksion "Recently Viewed Cars" edhe nëse përdoruesi nuk është kyqur.

---

### 🔹 Ndryshimi i përmbajtjes varësisht nga gjendja e cookies (psh ndryshim background, ndryshim i fotografive etj)
- **File**:  cardetails.php
- **Lines**:  36-42
- **Shembull / Përshkrim**:  Përmes cookies është mundësuar ndërrimi i përmbajtjes, në rastin tonë ndryshohet ngjyra e background, nëse recent_cars ekziston, pra nëse është shikuar të paktën një makinë nga përdoruesi.

---

### 🔹 Definimi dhe përdorimi i SESSIONS në PHP me të gjitha specifikat (krijimi, ruajtja, leximi)
- **File**: reservePage.php  
- **Lines**: 2, 11-22, 26-38  
- **Shembull / Përshkrim**:  Sesionet përdoren për të menaxhuar të dhënat e përdoruesit dhe hotelit. Në linjën 2, `session_start()` inicon sesionin. Në linjat 11-22, kontrollohet nëse `$_SESSION['user_id']` është vendosur për të verifikuar nëse përdoruesi është i kyçur; nëse jo, ridrejtohet te `login.php`. Në linjat 26-38, `$_SESSION['hotel_id']` ruhet dhe lexohet për të mbajtur ID-në e hotelit të zgjedhur nga URL (`$_GET['hotel_id']`) ose sesioni ekzistues, duke parandaluar aksesin e paautorizuar nëse ID-ja mungon ose është e pavlefshme.


---

### 🔹 Përdorimi i sesioneve për ndonjë qëllim të numërimit (vizita në faqe, forma, etj.)
- **File**:   `cardetails.php`
- **Lines**: 94 - 99  
- **Shembull / Përshkrim**:  Ky shembull tregon se si mund të numërohen vizitat për secilën makinë individualisht duke përdorur sesione. Përdoret një çelës unik (visitsoncarwithid{ID}) për secilën makinë bazuar në ID-në e saj. Nëse përdoruesi viziton për herë të parë atë makinë, vendoset vlera fillestare 1, përndryshe rritet numri i vizitave me ++. Kjo mund të përdoret për analiza statistikore ose për t’i treguar përdoruesit sa herë ka vizituar një makinë.

---

### 🔹 Shembull i përdorimit të funksionit brenda një PHP sesioni
- **File**:  `cars.php`
- **Lines**:  41-53
- **Shembull / Përshkrim**:  Në këtë shembull, një funksion i thjeshtë PHP ruhet si string brenda një variable të sesionit ($_SESSION['variabla']). Funksioni test() kur thirret, shfaq një mesazh të personalizuar për përdoruesin.

---

### 🔹 Manipulimi me PHP Sesione (ruajtje & ndryshim i vlerave, manipulime të ndryshme)
- **File**:  `reservePage.php`
- **Lines**:  26-32
- **Shembull / Përshkrim**:  Në linjat 26-32, vlera e $_SESSION['hotel_id'] manipulohet duke ruajtur ID-në e hotelit nga $_GET['hotel_id'] nëse është e pranishme dhe e vlefshme. Kjo lejon që hoteli i zgjedhur të mbahet gjatë gjithë sesionit të përdoruesit, duke mundësuar vazhdimësinë e rezervimit pa nevojën për të kaluar ID-në e hotelit në çdo kërkesë.

---

- **File**: `cars.php`
- **Lines**:  48-53
- **Shembull / Përshkrim**: Ky fragment demonstron si të ruash një mesazh në sesion dhe ta ndryshosh atë në mënyrë dinamike në bazë të një parametri në URL (?ndrysho). Fillimisht, nëse variabli $_SESSION['mesazhi'] nuk ekziston, caktohet një mesazh. Nëse URL-ja përmban parametrin ndrysho, mesazhi në sesion përditësohet me një version më të gjatë. Kjo është një mënyrë e thjeshtë për të kontrolluar përmbajtjen e shfaqur për përdoruesin në mënyrë dinamike përmes sesioneve.

---

##  PHP dhe MySQL

### 🔹 Konsepsioni dhe lidhja me DB
- **File**:db.php  
- **Lines**:  1-7
- **Shembull / Përshkrim**:  Lidhja me bazën e të dhënave realizohet në db.php, e cila përfshihet në linjën 4 të reserve Page.php me include '../db.php'. Kodi krijon një lidhje me MySQL duke përdorur mysqli për bazën web2_ebooking.


---

### 🔹 Krijimi i tabelave përmes PHP dhe ruajtja në DB
- **File**: db.php
 **Lines**: 21–171
- **Shembull / Përshkrim**:   Ekzekutimi i komandave `CREATE TABLE` për të krijuar strukturat e tabelave që ruajnë të dhënat e përdoruesve dhe rezervimeve.

---

### 🔹 3. Menaxhimi i të Dhënave (INSERT, DELETE, UPDATE)

#### ▪️ INSERT  
- **File**: submit_site_review.php
- **Lines**: 26  
- **Shembull / Përshkrim**:  
  Shtimi i një review të ri përmes query-t `INSERT INTO`, për të ruajtur komentet e përdoruesve në databazë.

#### ▪️ DELETE  
- **File**: user.php
- **Lines**: 28  
- **Shembull / Përshkrim**:  
  Fshirja e një review ose rezervimi përmes `DELETE FROM` — heqje e përhershme e të dhënave nga databaza.

#### ▪️ UPDATE  
- **File**: user.php
- **Lines**: 67–77  
- **Shembull / Përshkrim**:  
  Ndryshimi i statusit të një review nga ‘pending’ në ’approved’, duke përdorur query `UPDATE`  për moderimin e komenteve pa fshirje.

---

### 🔹 Lidhja me DB përmes një skripti të jashtëm (opsionale)
- **File**:  `db.php`  
- **Lines**:  1-11  
- **Shembull / Përshkrim**:  
  Në këtë skedar bëhet lidhja me databazën MySQL duke përdorur klasën `mysqli`.  
  Definohen parametrat e lidhjes (host, përdorues, fjalëkalim dhe emri i databazës),  
  pastaj krijohet objekti `$conn`. Nëse lidhja dështon, programi ndalet me një mesazh gabimi.  
  Ky skedar përdoret për të centralizuar dhe ripërdorur lidhjen në skedarë të tjerë PHP.

---

## Pointerë & Referenca 

### 🔹 Përdorimi dhe kuptimi i pointerëve në PHP
- **File**: `update_profile.php`
- **Lines**: 6-9, 11
- **Shembull / Përshkrim**:  
  Në funksionin `setResponseMessage(&$response, $status, $message)`, parametri `$response` përcillet si referencë (`&$response`). Kjo nënkupton se çdo ndryshim brenda funksionit reflektohet në variablën origjinale jashtë funksionit
---

### 🔹 Përcjellja përmes referencës (array, funksione, kthim)
- **File**: `update_profile.php`
- **Lines**: 6-11
- **Shembull / Përshkrim**:  
  Funksioni `setResponseMessage(&$response, $status, $message)` modifikon drejtpërdrejt array-n `$response` që është jashtë funksionit. Kjo ndodh sepse array-ja është kaluar me referencë, duke lejuar funksionin të ndërhyjë në të dhënat ekzistuese.

---

### 🔹 Çasje në variabla globale
- **File**:  
  - `user.php`: 3  
  - `update_profile.php`: 3, 15  
  - `update_password.php`: 3, 7  
- **Lines**: Shiko përshkrimin sipër për secilin file.
- **Shembull / Përshkrim**:  
  Variabla `$_SESSION` përdoret në shumë pjesë të aplikacionit për të ruajtur dhe lexuar të dhëna globale të përdoruesit të kyçur, si `$_SESSION['user_id']` dhe `$_SESSION['is_admin']`. Kjo është mënyra sesi PHP mundëson çasjen në variabla globale midis skedarëve dhe seancave.

---

### 🔹 Përdorimi i `unset()` dhe largimi i referencës
- **File**: `user.php`
- **Lines**: ~163, ~175
- **Shembull / Përshkrim**:  
  Funksioni `unset()` përdoret për të larguar referencat e përkohshme ndaj rreshtave të marrë nga `fetch_assoc()` dhe rezultateve të query-ve:  
  ```php
  unset($row);
  unset($result);
  unset($stmt);


## Siguria & SQL Injection 

### 🔹 5. Mbrojtja ndaj MySQL Injection  
- **File**: [user.php]
- **Lines**: 28, 39, 67, 77  
- **Shembull / Përshkrim**:  
  Për t’u mbrojtur nga SQL Injection është përdorur `preparedStatement` me `placeholder (?)`, në vend të vlerave të drejtpërdrejta.  
  Kjo teknikë është aplikuar gjatë përdorimit të query-ve `INSERT`, `UPDATE` dhe `DELETE`, duke parandaluar manipulimin e të dhënave përmes inputeve të jashtme.



### 🔹 Çfarë është obligative të përdorim gjithmonë kur dërgojmë të dhëna në server
- **File**:  reservePage.php
- **Lines**: 43-68, 74-89, 107-118 
- **Shembull / Përshkrim**:  Është obligative të përdoren deklarata të përgatitura (prepared statements) kur dërgohen të dhëna në server për të parandaluar SQL Injection. Në reservePage.php, të gjitha pyetësorët MySQL përdorin $stmt->prepare dhe $stmt->bind_param për të lidhur parametrat në mënyrë të sigurt, duke shmangur futjen e drejtpërdrejtë të të dhënave të përdoruesit në pyetësorë.


---

### 🔹 Shembull i mbrojtjes kundër MySQL Injection
- **File**:  cardetails.php
- **Lines**:  83-87
- **Shembull / Përshkrim**:  Janë përdorur prepared statements për tu mbrojtur nga MySQL Injection attacks, një dobësi e zakonshme sigurie ku sulmuesit përpiqen të manipulojnë SQL queries duke injektuar të dhëna keqdashëse.

---

## Files, Error Handling & Email


### 🔹 Përdorimi i funksioneve për manipulim me fajlla  
(*include(), require(), fopen(), fclose(), filesize(), fread(), fwrite()*)  
 
- **File**: index.php  
- **Lines**: 47-70  
- **Shembull / Përshkrim**:  
  Në këtë segment përdoren funksione për përfshirjen e skedarëve PHP dhe përpunimin e një forme që lejon përdoruesin të dërgojë një vlerësim (rating) dhe koment për faqen:
  - `include 'db.php';` dhe `include_once 'table_creator.php';` përfshijnë skedarët për lidhje me databazën dhe krijimin e tabelave.

---

- **File**:  AboutUs.php  
- **Lines**: 188-204  
- **Shembull / Përshkrim**:  
  Në këtë segment, përdoren funksionet e punës me fajlla për të lexuar përmbajtjen e një fajlli `news.json` që përmban lajme dhe datën e përditësimit.  
  - Përdoret `file_exists()` për të verifikuar nëse fajlli ekziston.
  - `fopen()` përdoret për ta hapur fajllin në mënyrë të sigurt për lexim.
  - `fread()` lexon të gjitha të dhënat nga fajlli sipas madhësisë me `filesize()`.
  - Përmbajtja konvertohet nga JSON në një array me `json_decode()`, dhe më pas verifikohet nëse ka ndonjë gabim me `json_last_error()` dhe `json_last_error_msg()`.
  - Në fund, `fclose()` mbyll fajllin.

--- 

### 🔹 Definimi i funksionit për trajtim të gabimeve error_handler me të gjithe parametrat
- **File**:  `cardetails.php`
- **Lines**:   52-60
- **Shembull / Përshkrim**:  Në këtë shembull është përdorur funksioni customErrorHandler($errno, $errstr, $errfile, $errline) për të trajtuar gabimet në mënyrë të personalizuar. Parametrat e funksionit kapin informacionin e plotë rreth gabimit, përfshirë llojin, përshkrimin, skedarin dhe linjën ku ndodhi. Përmes set_error_handler(), ky funksion zëvendëson trajtuesin standard të PHP-së dhe paraqet gabimet si një bllok HTML të stilizuar, duke e bërë më të lehtë identifikimin e tyre gjatë zhvillimit. Kjo qasje përmirëson dukshmërinë dhe kontrollin gjatë debugimit.

---

### 🔹 Gabime të personalizuara në shqip  
- **File**:  `hotels.php`  
- **Lines**:  21-25  
- **Shembull / Përshkrim**:  Kontrollohet nëse data e check-in-it është në të kaluarën dhe në atë rast vendoset një mesazh gabimi në `$error_message`. 
---

- **File**:  `hotels.php`  
- **Lines**:  35, 52, 66, 78  
- **Shembull / Përshkrim**:  Në disa raste përdoret `error_log(...)` për të regjistruar gabime kur `query` dështojnë. Edhe pse këto nuk janë të ekspozuara direkt për përdoruesin, mund të zëvendësohen ose të kombinohen me mesazhe për përdoruesin për një përvojë më miqësore. Mund të përdoret një strukturë si `$_GET['error']` për t'i shfaqur këto gabime në faqen e përparme në shqip.


---

- **File**:  `cardetails.php`  
- **Lines**:  65, 90
- **Shembull / Përshkrim**:  Në këtë shembull përdoret funksioni trigger_error() për të ngritur gabime të personalizuara në dy raste specifike:
Kur ID e makinës është më e vogël se 0 (e pavlefshme),
Kur nuk gjendet asnjë e dhënë për makinën me atë ID.
Këto gabime klasifikohen si E_USER_WARNING dhe aktivizohen qëllimisht për të ndihmuar në diagnostikimin e situatave të padëshiruara gjatë ekzekutimit.

---

### 🔹 TRY, CATCH, THROW  
- **File**:  `hotels.php`  
- **Lines**:  147-163  
- **Shembull / Përshkrim**:  Këtu përdoret struktura `try` dhe `catch` për përgatitjen dhe ekzekutimin e query-t për listimin e hoteleve. Nëse `prepare()` dështon, hidhët një përjashtim me `throw new Exception(...)`. Në `catch`, shfaqet mesazhi gabim me `echo` dhe procesi ndalet me `exit;`. Kjo i jep mundësi zhvilluesit të kontrollojë gabimet me më shumë fleksibilitet dhe të ruajë qëndrueshmërinë e sistemit.

---

- **File**:  `hotels.php`  
- **Lines**:  143-146  
- **Shembull / Përshkrim**:  Edhe pse nuk është në `try/catch`, përdoret `die()` për të ndaluar skriptin nëse `prepare()` ose `bind_param()` dështon. Këto mund të zëvendësohen me `throw new Exception(...)` dhe të kapen më vonë për të unifikuar trajtimin e gabimeve. 
---

- **File**:  `hotels.php`  
- **Lines**:  114-131  
- **Shembull / Përshkrim**:  Gabimet gjatë përgatitjes së `COUNT(*)` query për hotele gjithashtu kapen me `die(...)`.
---

### 🔹 PHP Email

---

#### Përdorimi i funksionit `mail()` me të gjitha parametrat  
- **File**:  `send_email.php`  
- **Lines**:  Linjat 62-80 (pjesa ku dërgohet emaili me PHPMailer)  
- **Shembull / Përshkrim**:  
  Në këtë pjesë përdoret PHPMailer për të dërguar email me SMTP. Konfigurohen hosti (`smtp.gmail.com`), porta (587), enkriptimi STARTTLS, përdoruesi dhe fjalëkalimi. Vendoset emaili dërgues dhe marrës, subjekti dhe përmbajtja në HTML dhe tekst. Në fund ekzekutohet metoda `send()`.

---

#### Formë standarde për dërgim emaili  
- **File**:  `send_email.php`  
- **Lines**:  Linjat 69-79 (krijimi i përmbajtjes së email-it me HTML dhe tekst)  
- **Shembull / Përshkrim**:  
  Këtu është forma standarde e përgatitjes së trupit të email-it në format HTML dhe tekst (alternative). Kjo siguron shfaqje të saktë në klientët e email-it.

---

#### Përdorimi i email-it të zakonshëm (gmail, yahoo, hotmail)  
- **File**:  `send_email.php`  
- **Lines**:  Linjat 62-84 (konfigurimi SMTP i Gmail me PHPMailer)  
- **Shembull / Përshkrim**:  
  Konfigurimi i SMTP për Gmail përfshin hostin, portën, përdoruesin, fjalëkalimin, dhe mënyrën e enkriptimit për të dërguar email-in në mënyrë të sigurt.

---

#### (Opsionale) FILTER_SANITIZE për mbrojtje  
- **File**:  `send_email.php`  
- **Lines**:  Linjat 12-27 (filtrimi dhe validimi i input-it)  
- **Shembull / Përshkrim**:  
  Këtu përdoret `filter_input()` me `FILTER_SANITIZE_STRING` dhe `FILTER_SANITIZE_EMAIL` për të pastruar emrin, emailin dhe mesazhin nga forma POST. Më pas bëhet validimi i email-it dhe kontrollimi nëse fushat janë plotësuar.

---

## PHP & AJAX

### 🔹 AJAX për lexim dhe update nga skriptë PHP  
- **File**:  
  - `ajax-login.php`  
  - `ajax-register.php`  
  - `update_profile.php`  
  - `update_password.php`  
- **Lines**:  
  - `ajax-login.php`: `1–13`, `56–60`  
  - `ajax-register.php`: `1–13`, `57–61`  
  - `update_profile.php`: `1–20`, `65–70`  
  - `update_password.php`: `1–18`, `73–78`  
- **Shembull / Përshkrim**:  
  Këto skripta marrin të dhëna nga forma përmes kërkesave `AJAX POST`, kryejnë validime në anën e serverit (p.sh. fjalëkalimi, email-i, fusha bosh), dhe kthejnë përgjigje në format JSON që përmban `status`, `success` ose `message`, pa rifreskuar faqen. Kjo është përdorim tipik i AJAX për komunikim me skriptë PHP.

---

### 🔹 AJAX për lexim dhe update nga databaza  
- **File**:  
  - `ajax-login.php`  
  - `ajax-register.php`  
  - `update_profile.php`  
  - `update_password.php`  
- **Lines**:  
  - `ajax-login.php`: `14–54`  
  - `ajax-register.php`: `14–54`  
  - `update_profile.php`: `22–64`  
  - `update_password.php`: `20–71`  
- **Shembull / Përshkrim**:  
  - **`ajax-login.php`** lexon të dhënat e përdoruesit nga databaza përmes `SELECT`, pastaj verifikon fjalëkalimin dhe rifreskon sesionin.  
  - **`ajax-register.php`** bën `SELECT` për të verifikuar nëse email-i ekziston dhe më pas `INSERT` për të shtuar përdoruesin e ri.  
  - **`update_profile.php`** përditëson të dhënat e profilit të përdoruesit me `UPDATE` mbi emrin, mbiemrin, numrin e telefonit, gjininë, etj.  
  - **`update_password.php`** lexon `password_hash` nga databaza për të verifikuar fjalëkalimin e vjetër dhe nëse është korrekt, e përditëson me një `UPDATE`.

---

### 🔹 Përdorimi i një Web API në projekt
- **File**:  `hotels.php`  
- **Lines**:  172-204  
- **Shembull / Përshkrim**:  
  Ky shembull ilustron integrimin e një API-je të jashtme – në këtë rast OpenWeatherMap – për të marrë të dhënat e motit për secilin qytet që lidhet me një hotel nga databaza.  
  Fillimisht përgatitet dhe ekzekutohet një query SQL. Për secilën rresht që përfaqëson një hotel, merret emri i qytetit dhe dërgohet kërkesë për të marrë të dhënat e motit në format JSON.  
  Më pas, të dhënat dekodohen dhe temperatura aktuale dhe përshkrimi i motit shtohen si një pjesë shtesë (`$row['weather']`) në të dhënat e hotelit.  
  Në fund, këto të dhëna mund të shfaqen në UI për të ofruar më shumë informacion kontekstual për përdoruesin.

---




