# 📘 Dokument Template - Pjesa e Parë (PHP Bazik & OOP)

Ky dokument shërben si template për të dokumentuar fazën e parë të projektit tuaj në PHP. Për çdo seksion, mund të shtoni skedarin dhe linjat ku është zbatuar funksionaliteti.

---

## ✅ Konceptet Themelore të PHP-së

### 🔹 Variablat, qasja e tyre, `var_dump()`, funksionet, funksionet për stringje
**Funksioni**:
- **File**: [carclass.php](https://github.com/ErmirMeziu/WEB2-Ebooking/blob/main/src/Cars-Page/carclass.php)
- **Lines**: 42-63
- **Shembull / Përshkrim**: Perdorimi i funksionit per me i sortu vargjet te objektet e cardetails
  
-**var_dump**:
- **File**: [cardetails.php](https://github.com/ErmirMeziu/WEB2-Ebooking/blob/main/src/Cars-Page/cardetails.php)
- **Lines**: 177
- **Shembull / Përshkrim**: Perdorimi i var_dump
  
-**String functions**:
- **File**: [login_register.php](https://github.com/ErmirMeziu/WEB2-Ebooking/blob/main/src/components/login_register.php)
- **Lines**: 151-152

---

### 🔹 Konstante & Operatorë (përfshirë ternarin)
- **File**: [index.php](https://github.com/ErmirMeziu/WEB2-Ebooking/blob/main/src/index.php)
- **Lines**: 164, 179, 194

---

### 🔹 Kushtëzime (`if..else`, `switch`)
-**if-else**
- **File**:  [cardetails.php](https://github.com/ErmirMeziu/WEB2-Ebooking/blob/main/src/Cars-Page/cardetails.php)
- **Lines**: 173-179
  
-**switch**
- **File**: [carclass.php](https://github.com/ErmirMeziu/WEB2-Ebooking/blob/main/src/Cars-Page/carclass.php)
- **Lines**: 43-60
- **Shembull / Përshkrim**: N’baze t’id t’cars me i sortu vargjet te objektet e cardetails

---

### 🔹 Arrays – Numeric, Associative, Multidimensional
-**Array**:
- **File**: [hotels.php](https://github.com/ErmirMeziu/WEB2-Ebooking/blob/main/src/Hotel%20Page/hotels.php)
- **Lines**: 361
- **Shembull / Përshkrim**: Ruajta e objekteve te hoteleve ne array.

-**Associative//Multidimensional**:
- **File**: [cardetails.php](https://github.com/ErmirMeziu/WEB2-Ebooking/blob/main/src/Cars-Page/cardetails.php)
- **Lines**: 42

---

### 🔹 Funksione të sortimit në PHP (`sort`, `rsort`, `asort`, `ksort`, `arsort`, `krsort`)
-**usort**:
- **File**: [index.php](https://github.com/ErmirMeziu/WEB2-Ebooking/blob/main/src/index.php)
- **Lines**: 121
  
-**Sortimet tjera**
- **File**: 
[carclass.php](https://github.com/ErmirMeziu/WEB2-Ebooking/blob/main/src/Cars-Page/carclass.php)
- **Lines**: 44-57


---

### 🔹 Variabla globale (`$_GET`, `$_SERVER`)
-**$_POST**:
- **File**: [login_register.php](https://github.com/ErmirMeziu/WEB2-Ebooking/blob/main/src/components/login_register.php) 
- **Lines**: 148-153, 170-174
- **Shembull / Përshkrim**: Marrja e input prej formes permes $_POST.

-**$_SERVER**:
- **File**: [hotels.php](https://github.com/ErmirMeziu/WEB2-Ebooking/blob/main/src/Hotel%20Page/hotels.php) 
- **Lines**: 38-43
- **Shembull / Përshkrim**: Perfshirja e header dhe footer ne file me $_SERVER.

---

## 🧱 OOP në PHP

### 🔹 Definimi dhe përdorimi i klasave me veti dhe metoda
-**Klasa**:
- **File**: [index.php](https://github.com/ErmirMeziu/WEB2-Ebooking/blob/main/src/index.php)
- **Lines**:100, 325

-**Klasa abstrakte**:
- **File**: [index.php](https://github.com/ErmirMeziu/WEB2-Ebooking/blob/main/src/index.php)
- **Lines**:145

---

### 🔹 Konstruktorë & Destruktorë
-**Konstruktor**:
- **File**: [index.php](https://github.com/ErmirMeziu/WEB2-Ebooking/blob/main/src/index.php) 
- **Lines**: 338, 157
  
-**Destruktor**:
- **File**: [login_register.php](https://github.com/ErmirMeziu/WEB2-Ebooking/blob/main/src/components/login_register.php) 
- **Lines**: 126


---

### 🔹 Getters & Setters
- **File**: [hotels.php](https://github.com/ErmirMeziu/WEB2-Ebooking/blob/main/src/Hotel%20Page/hotels.php)
- **Lines**: 298-303
- **Shembull / Përshkrim**:Perdorimi i set() dhe get() per private variable.

---

### 🔹 Modifikatorët: `public`, `private`, `protected`
- **File**:[hotels.php](https://github.com/ErmirMeziu/WEB2-Ebooking/blob/main/src/Hotel%20Page/hotels.php) 
- **Lines**: 261-276


---

### 🔹 Trashëgimia në PHP (`carclass.php`)

- **File**:[carclass.php](https://github.com/ErmirMeziu/WEB2-Ebooking/blob/main/src/Cars-Page/carclass.php)
- **Lines**: 1-64

- **File**: [index.php](https://github.com/ErmirMeziu/WEB2-Ebooking/blob/main/src/index.php)
- **Lines**: 163

---



## 🔍 PHP Shprehjet e Rregullta (RegEx)

### 🔹 Kuptimi & përdorimi për validim/kontroll
- **File**: [login_register.php](https://github.com/ErmirMeziu/WEB2-Ebooking/blob/main/src/components/login_register.php)
- **Lines**: 155-183
- **Shembull / Përshkrim**:U thirren funksionet e regex per validimin e inputs.

---

### 🔹 Validime me RegEx (email, data, numra)
- **File**: [login_register.php](https://github.com/ErmirMeziu/WEB2-Ebooking/blob/main/src/components/login_register.php)
- **Lines**: 88, 101
- **Shembull / Përshkrim**:U përdor per validim te hyrjeve nga register dhe login.

---

### 🔹 Manipulim numrash (ndarje me simbol, etj.)
- **File**: [login_register.php](https://github.com/ErmirMeziu/WEB2-Ebooking/blob/main/src/components/login_register.php)

- **Lines**: 94
- **Shembull / Përshkrim**: Ndarja e numrit nga 123456789 ne 123-456-789.

---
### 🔹 RegEx për manipulim stringjesh
- **File**: [cars.php](https://github.com/ErmirMeziu/WEB2-Ebooking/blob/main/src/Cars-Page/cars.php)
- **Lines**: 168,208
- **Shembull / Përshkrim**: Per kushtin manipulim te stringjesh kemi perdorur funksionin preg_replace ku permes ketij funksioni kemi zevendesuar fjalen Automatic ne Manual, dhe permes te njejtit funksion ne rreshtin 208 kemi nderruar fjalen Diesel me Benzine.

---

---------------------------------------------------Pjesa e dytë-----------------------------------------------------
## 🔍 PHP dhe MySQL —

### 🔹 1. Lidhja me Bazën e të Dhënave  
- **File**: [user.php](https://github.com/ErmirMeziu/WEB2-Ebooking/tree/main/src/user)  
- **Lines**: 2  
- **Shembull / Përshkrim**:  
  Përdorimi i `mysqli_connect` ose `PDO` për krijimin e një lidhjeje të sigurt me bazën e të dhënave në *phpMyAdmin*.

---

### 🔹 2. Krijimi i Tabelave përmes PHP  
- **File**: [db.php](https://github.com/ErmirMeziu/WEB2-Ebooking/blob/main/src/db.php)  
- **Lines**: ~21–171  
- **Shembull / Përshkrim**:  
  Ekzekutimi i komandave `CREATE TABLE` për të krijuar strukturat e tabelave që ruajnë të dhënat e përdoruesve dhe rezervimeve.

---

### 🔹 3. Menaxhimi i të Dhënave (INSERT, DELETE, UPDATE)

#### ▪️ INSERT  
- **File**: [submit_site_review.php](https://github.com/ErmirMeziu/WEB2-Ebooking/blob/main/src/user/submit_site_review.php)  
- **Lines**: 26  
- **Shembull / Përshkrim**:  
  Shtimi i një review të ri përmes query-t `INSERT INTO`, për të ruajtur komentet e përdoruesve në databazë.

#### ▪️ DELETE  
- **File**: [user.php](https://github.com/ErmirMeziu/WEB2-Ebooking/tree/main/src/user)  
- **Lines**: 28  
- **Shembull / Përshkrim**:  
  Fshirja e një review ose rezervimi përmes `DELETE FROM` — heqje e përhershme e të dhënave nga databaza.

#### ▪️ UPDATE  
- **File**: [user.php](https://github.com/ErmirMeziu/WEB2-Ebooking/tree/main/src/user)  
- **Lines**: 67–77  
- **Shembull / Përshkrim**:  
  Ndryshimi i statusit të një review nga *pending* në *approved*, duke përdorur query `UPDATE` — për moderimin e komenteve pa fshirje.

---

### 🔹 4. Lidhja nga një Skriptë e Jashtme  
- **File**: [user.php](https://github.com/ErmirMeziu/WEB2-Ebooking/tree/main/src/user)  
- **Lines**: 187–190  
- **Shembull / Përshkrim**:  
  Skripti i jashtëm është përdorur për të përfshirë komponentin e navbar-it në faqe të ndryshme — për të mundësuar rishfrytëzimin e kodit dhe mirëmbajtjen më të lehtë të strukturës.

---

### 🔹 5. Mbrojtja ndaj MySQL Injection  
- **File**: [user.php](https://github.com/ErmirMeziu/WEB2-Ebooking/tree/main/src/user)  
- **Lines**: 28, 39, 67, 77  
- **Shembull / Përshkrim**:  
  Për t’u mbrojtur nga SQL Injection është përdorur `preparedStatement` me `placeholder (?)`, në vend të vlerave të drejtpërdrejta.  
  Kjo teknikë është aplikuar gjatë përdorimit të query-ve `INSERT`, `UPDATE` dhe `DELETE`, duke parandaluar manipulimin e të dhënave përmes inputeve të jashtme.

---
