<?php
/*
 * Class OkiPHPQL by okierie | This project is licensed under the terms of the MIT license
 * Dibuat untuk menyederhanakan penulisan query dalam pemrograman php terstruktur
 * dengan menggunakan driver mysqli dan kompatibel dengan PHP versi 5.2+
 * Penggunaan fungsi harus mengikuti standar dalam class ini
 * Jika kondisi query tidak standar maka class ini harus disesuaikan/diubah/ditambah fungsinya
 * Silakan gunakan dan modifikasi sesuai dengan kebutuhan Anda
 * Baca README.md untuk petunjuk penggunaan
 * repository https://github.com/okierie/OkiPHPQL
----------------------------------------------------
MIT License

Copyright (c) 2016 Oki Erie Rinaldi

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
----------------------------------------------------
 */
class OkiPHPQL {
	function __construct($dbhost=NULL,$dbuser=NULL,$usrpwd=NULL,$dbname=NULL) {
		// setting koneksi
		$dbhost	= $dbhost == NULL ? "localhost" : $dbhost;// host database | ganti dbhost dengan host database yang digunakan
		$dbuser	= $dbuser == NULL ? "root" : $dbuser;// user | ganti dbuser dengan user yang digunakan
		$usrpwd	= $usrpwd == NULL ? "123" : $usrpwd;// password user | ganti usrpwd dengan password untuk user yang digunakan
		$dbname	= $dbname == NULL ? "tester" : $dbname;// nama database |ganti dbname dengan nama database yang digunakan
		$this->kon	= new mysqli($dbhost, $dbuser, $usrpwd, $dbname);
	}
	function insert($nmtabel,$isi){// simpan satu record, $isi harus berbrntuk array => key : nama kolom, value : isi kolom
		if ($nmtabel != NULL AND $isi != NULL AND is_array($isi)){
			$cols	= array(); $values	= array();
			foreach ($isi as $k => $v){// k = array key, v = array value
				$cols[]		= "`".$k."`";
				$values[]	= "'".$v."'";
			}
			$cols	= implode(",",$cols);
			$values	= implode(",",$values);
			$qsimpan	= "INSERT INTO `$nmtabel` ($cols) VALUES ($values)";

			$proses	= $this->kon->query($qsimpan);
			if ($proses){
				return TRUE;
			}
			else{
				return FALSE;
			}
		}
		else{
			return FALSE;
		}
	}
	function update($nmtabel,$isi,$wh){// update record, $isi harus berbrntuk array => key : nama kolom, value : isi kolom, $wh adalah string atau array => key : nama kolom, value : isi kolom
		if ($nmtabel != NULL AND $isi != NULL AND is_array($isi)){
			// update detail
			$updset	= array();;
			foreach ($isi as $k => $v){// k = array key, v = array value
				$updset[]	= "`$k` = '$v'";
			}
			$updset	= implode(",",$updset);
			// where
			$where		= $this->_where($wh);
			$qupdate	= "UPDATE `$nmtabel` SET $updset $where";
			$this->kon->query($qupdate);
		}
		else{
			return FALSE;
		}
	}
	function delete($nmtabel,$wh){
		if ($nmtabel != NULL AND $wh != NULL){// untuk mencegah ketidaksengajaan pemanggilan fungsi, maka wh harus diisi | jika ingin menghapus semua record maka isi wh dengan 1
			$where		= $this->_where($wh);
			$qdelete	= "DELETE FROM `$nmtabel` WHERE $wh";
			$this->kon->query($qdelete);
		}
	}
	function select($nmtabel,$wh="",$cols="*"){// selalu return sebagai array asosiatif
		$where	= $this->_where($wh);
		$qselect	= "SELECT $cols FROM $nmtabel $where";
		return $this->kon->query($qselect)->fetch_all(MYSQLI_ASSOC);
	}
	function query($query,$ret=TRUE){
		$proceed	= $this->kon->query($qdelete);
		if ($ret){
			$result	= $proceed->fetch_all(MYSQLI_ASSOC);
			return $result;
		}
	}
	function _where($wh){
		// where
		if (is_array($wh)){
			if (count($wh) > 0){
				$where	= array();
				foreach ($wh as $k => $v){// k = array key, v = array value
					$where[]	= "`$k` = '$v'";
				}
				$where	= implode(" AND ",$where);
				$where	= "WHERE $where";
			}
			else{
				$where	= "";
			}
		}
		else{
			if ($wh != "" AND $wh != NULL){
				$where	= "WHERE $wh";
			}
			else{
				$where	= "";
			}
		}
		return $where;
	}
}
