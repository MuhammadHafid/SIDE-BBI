<?php

function cekSessionLogin()
{

	$ci = get_instance();

	if (!$ci->session->userdata('online')) {

		redirect('auth');
	}


	// if(!$_COOKIE[$ci->session->userdata('username')]) {
	// 	// update tabel user online = 0
	// 	$ci->db->set('online', 0);
	// 	$ci->db->where('username =', $ci->session->userdata('username'));
	// 	$ci->db->update('user');

	// 	setcookie($ci->session->userdata('username'), '');

	// 	$ci->load->view('auth/login');
	// }



	// if (!isset($_COOKIE[$ci->session->userdata('username')])) {

	// }

}



if (!function_exists('redirectPreviousPage')) {
	function redirectPreviousPage()
	{
		if (isset($_SERVER['HTTP_REFERER'])) {
			header('Location: ' . $_SERVER['HTTP_REFERER']);
		} else {
			header('Location: http://' . $_SERVER['SERVER_NAME']);
		}

		exit;
	}
}





function is_logged_in()
{

	$ci = get_instance();

	if (!$ci->session->userdata('nama')) {

		redirect('auth');
	} else {


		$role = $ci->session->userdata('role');

		$menus = $ci->uri->segment(1);

		// $queryMenu = $ci->db->get_where('user_menu', ['menu' => $menus])->row_array();

		// $menu_id = $queryMenu['id'];

		$queryAccess = $ci->db->get_where(
			'user_sub_menu',
			[
				'menu_id' => $role,
				'url' => $menus
			]
		);

		// var_dump($queryAccess->num_rows());die;

		if ($queryAccess->num_rows() < 1) {

			redirect('auth/blocked');
		}
	}
}





function check_access($role_id, $menu_id)
{

	$ci = get_instance();

	$result = $ci->db->get_where('user_access_menu', [
		'level_id' => $role_id,
		'menu_id' => $menu_id
	]);


	if ($result->num_rows() > 0) {

		return "checked='checked'";
	}
}








function admin_access()
{

	$ci = get_instance();

	if ($ci->session->userdata('role') != '1') {

		redirect('auth/blocked');
	}
}








function divdua_block()
{

	$ci = get_instance();

	if ($ci->session->userdata('username') == 'rendhy' || $ci->session->userdata('username') == 'rendhy2') {

		redirect('auth/blocked');
	}
}








function check_ambil($id)
{

	$ci = get_instance();

	$result = $ci->db->get_where('kasbon', [
		'id' => $id
	])->row_array();

	if ($result['ambil'] > 0) {

		return "checked='checked'";
	}
}





// function check_jurnal($id_jurnal){

// 	$ci = get_instance();

// 	$queryJurnal= "
// 	SELECT grup_jurnal
// 	FROM jurnal
// 	WHERE id_jurnal = $id_jurnal
// 	"

// 	$data['jurnal'] = $ci->db->get($queryJurnal)->row_array();

// 	return "value = " .$data['jurnal']['grup_jurnal'] "";


// }

// $result= $ci->db->get_where('jurnal', [
// 	'id_jurnal' => $id_jurnal
// ]);



// if ($result->num_rows() > 0) {

// 	return "checked='checked'";

// }
