<?php
#####################################################################################
#  Module Download Updater for Opencart 1.5.x From Eric Baker ericbaker.me 			#
#####################################################################################

class ModelToolDownloadUpdater extends Model 
{

	public function getAllDownloads() {
		//Get a list of all downloads so we can start iterating through it
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "download");

		return (isset($query->assoc['download'])) ? $query->assoc['download'] : 0;
	}
	
	public function getDownloadId($download_name) {
		//Find a download by way of name
		$query = $this->db->query("SELECT download_id FROM " . DB_PREFIX . "download_description WHERE name LIKE '\%".$download_name."%\' LIMIT 1");

		return (isset($query->row['download_id'])) ? $query->row['download_id'] : 0;
	}

	public function getProductId($download_name) {
		//Find a product based on the Model if there isn't a download already associated with it

		//Get the product ID that matches the given download name from the filename
		$query = $this->db->query("SELECT product_id FROM " . DB_PREFIX . "product WHERE model = '".$download_name."' LIMIT 1");
		if(isset($result = $query->row['product_id'])) {
			//There is a product that matches the download name given, so now we need to...
			//verify that product doesn't already link to a download
			$download_id = getDownloadId($download_name);
			$query = $this->db->query("SELECT product_id FROM " . DB_PREFIX . "product_to_download WHERE download_id = '" . $download_id . "'");

			//If the number of rows is zero (there isn't a match), then allow it to continue
			//Otherwise, act as if there isn't a product that matches
			return (isset($query->row['product_id'])) ? 0 : $query->row['product_id'];
		}
	}

	public function createDownloadLink($product_id, $download_id) {
		//Create a link between the download and the product

		$query = $this->db->query("INSERT INTO " . DB_PREFIX . "product_to_download (product_id, download_id) VALUES ('" . $product_id . "', " . $download_id . "'");
	
		return ($query->affected_rows > 0) ? true : false;
	}	

}


?>