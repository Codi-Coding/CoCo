<?php
	function eb_admin_paging($skin_dir="") {
		global $paging, $page, $total_page, $atpl;

		if(!$skin_dir) $skin_dir = "basic";
		$cur_page	= $page;
		$pg_pages	= $paging['pages'];
		$pg_url		= $paging['url'];
		$tpl_name	= $paging['tpl'];

		$pg_url		= preg_replace('#&amp;page=[0-9]*#', '', $pg_url).'&amp;page=';
		$start_page = (((int)(($cur_page-1)/$pg_pages))*$pg_pages)+1;
		$end_page	= $start_page+$pg_pages-1;

		if (!$total_page) $total_page = 1;
		if ($end_page >= $total_page) $end_page = $total_page;

		$str = array();
		if ($total_page > 1) {
			for ($k=$start_page;$k<=$end_page;$k++) {
				$str[$k]['url'] = $pg_url.$k.$add;
				if ($cur_page != $k)
					$str[$k]['on'] = false;
				else
					$str[$k]['on'] = true;
			}
		}

		$atpl->define(array(
			'pc' => 'skin_pc/paging/' . $skin_dir . '/paging.skin.html',
			'mo' => 'skin_mo/paging/' . $skin_dir . '/paging.skin.html',
			'bs' => 'skin_bs/paging/' . $skin_dir . '/paging.skin.html',
		));
		$atpl->assign(array(
			'paging'	 => $str,
			'url'		 => $pg_url,
			'cur_page'	 => $cur_page,
			'start_page' => $start_page,
			'total_page' => $total_page,
			'end_page'	 => $end_page,
			'add'		 => $add,
		));
		$atpl->print_($tpl_name);
	}
?>