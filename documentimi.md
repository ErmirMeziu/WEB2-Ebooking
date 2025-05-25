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

## 🔍PHP dhe MySQL —

🔹 1. Lidhja me Bazën e të Dhënave
🔵 File: [[user.php](https://github.com/ErmirMeziu/WEB2-Ebooking/tree/main/src/user)]
🔵 Lines: [2]
🔵 Shembull / Përshkrim:
Përdorimi i mysqli_connect ose PDO për të krijuar një lidhje të sigurt me bazën e të dhënave myphpadmin

🔹 2. Krijimi i Tabelave përmes PHP
🔵 File: [db.php](https://github.com/ErmirMeziu/WEB2-Ebooking/blob/main/src/db.php)
🔵 Lines: [p.sh. 21–171]
🔵 Shembull / Përshkrim:
Ekzekutimi i query-ve CREATE TABLE për të krijuar struktura tabelash për ruajtjen e të dhënave.

🔹 3. Menaxhimi i të Dhënave (INSERT, DELETE, UPDATE)
🔵 INSERT INTO
🔵 File: [submit_site_review.php](https://github.com/ErmirMeziu/WEB2-Ebooking/blob/main/src/user/submit_site_review.php)
🔵 Lines: [26]
🔵 Shtimi i review të ri / Për të ruajtur komente të reja nga përdoruesit

🔵 DELETE INTO 
🔵 File: [[user.php](https://github.com/ErmirMeziu/WEB2-Ebooking/tree/main/src/user)]
🔵 Lines: [28]
🔵 	Fshirja e review ose rezervimi të makinës/Për të hequr përgjithmonë një të dhënë nga DB

🔵 UPDATE INTO 
🔵 File: [[user.php](https://github.com/ErmirMeziu/WEB2-Ebooking/tree/main/src/user)]
🔵 Lines: [67-77]
🔵 Ndryshimi i statusit të review (p.sh. nga pending në approved)	 / Për të moderuar komente pa i fshirë

🔹 4. Lidhja nga një Skriptë e Jashtme
🔵 File: [[user.php](https://github.com/ErmirMeziu/WEB2-Ebooking/tree/main/src/user)]
🔵 Lines: [187-190]
🔵 Kjo script e jashtme eshte perdorur ne menyre qe te riperedorim pjesen e kodit te navbarit dhe te jete me i lehte per mirembajtje 

🔵 UPDATE INTO 
🔵 File: [[user.php](https://github.com/ErmirMeziu/WEB2-Ebooking/tree/main/src/user)]
🔵 Lines: [67-77]
🔵 Ndryshimi i statusit të review (p.sh. nga pending në approved)	 / Për të moderuar komente pa i fshirë

## 🔍MySQL Injection 
🔹 MySQL Injection 
🔵 Çfarë metoda janë përdorur për t’u mbrojtur nga SQL Injection
🔵 File: [[user.php](https://github.com/ErmirMeziu/WEB2-Ebooking/tree/main/src/user)]
🔵 Lines: [28-39-67-77..]
🔵 Per tu mbrojtur nga SQL Injection eshte perdor preparedStatment ku ne vend te vlerave reale kemi perdorur placeholder("?") dhe i kemi perdor sa here qe kemi bere update insert delete per te dhenat nga databaza