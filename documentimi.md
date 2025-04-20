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


