<?php
#####################################################################################
#  Module Download Updater for Opencart 1.5.x From Eric Baker ericbaker.me 			#
#####################################################################################

class ControllerToolDownloadUpdater extends Controller {
	private $error = array();
	private $total_items_updated = 0;

	public function index() {
		$this->load->language('tool/download_updater');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');
		$this->load->model('localisation/language'); //For getLanguages()	
		$this->load->model('tool/download_updater'); //For getAllDownloads(), getDownloadId($download_name), getProductId($download_name), and createDownloadLink($product_id, $download_id)
		
		// DO THE IMPORT
		if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validate()) {
			
			$this->model_setting_setting->editSetting('csv_import', $this->request->post);	
			
			$filename = $this->fetchFeed();
			
			if ($filename) {
				//now we know there is a file, we will delete existing products if necessary
				if ($this->request->post['csv_import_type'] == 'reset') {
					$this->model_tool_csv_import->emptyTables();
				}
				
				$this->import($filename);

				$this->session->data['success'] = sprintf($this->language->get('text_success'), $this->total_items_added, $this->total_items_updated, $this->total_items_skipped, $this->total_items_missed);
				if (!($this->total_items_added + $this->total_items_updated + $this->total_items_missed + $this->total_items_skipped)) {
					$this->session->data['success'] .= '<br/>Mac users: Make sure you save your file as CSV (Windows), not the default CSV format.';
				}
				$this->redirect($this->url->link('tool/csv_import', 'token=' . $this->session->data['token'], 'SSL'));
			}
			else {
				//no file or empty file, send warning
				$this->error['warning'] = $this->language->get('error_empty');
			}
		}


		// SPECIFY REQUIRED LANGUAGE TEXT
		$language_info = array(
			'heading_title',
			'text_success',
			'button_update',
			'error_permission',
		);
		
		// GET REQUIRED LANGUAGE TEXT
		foreach ($language_info as $language) {
			$this->data[$language] = $this->language->get($language); 
		}
		
		// Warning or success message
		$this->data['error_warning'] = (isset($this->error['warning'])) ? $this->error['warning'] : '';

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		// BCT
  		$this->data['breadcrumbs'] = array();
   		$this->data['breadcrumbs'][] = array(
       		'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);
   		$this->data['breadcrumbs'][] = array(
       		'href'      => $this->url->link('tool/download_updater', 'token=' . $this->session->data['token'], 'SSL'),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
		
		// Control buttons in admin
		$this->data['action'] = $this->url->link('tool/download_updater', 'token=' . $this->session->data['token'], 'SSL');

		$this->template = 'tool/download_updater.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
		$this->response->setOutput($this->render());
	}
	
	private function updateProduct($update_id, &$raw_prod) {
		
	}
	
	private function validate() 
	{
		//have permission?
		if (!$this->user->hasPermission('modify', 'tool/download_updater')) {
			$this->error['warning'] = $this->language->get('error_permission');
		} 

		return (!$this->error);
	}
}
?>