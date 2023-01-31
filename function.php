<?

// Т.к. нет своей демо коробки, использую облако, +- похожих отчетов нет, но с коробки прислал код ниже по другим задачам

// https://github.com/egAstah/moduleWareAccounting.git
// https://github.com/egAstah/moduleGroupContact.git

function callMethod($queryMethod, $data)
{
    $queryUrl = 'https://b24-7qm3jf.bitrix24.ru/rest/1/552qb0kh06hnp1it/' . $queryMethod;
    $queryData = http_build_query($data);

    $curl = curl_init();
    curl_setopt_array(
        $curl,
        array(
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_POST => 1,
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $queryUrl,
            CURLOPT_POSTFIELDS => $queryData,
        )
    );

    $result = curl_exec($curl);
    curl_close($curl);

    $result = json_decode($result, 1);

    return $result;
}
switch ($_POST['event']){
    case 'print-table':
        $listDeal = callMethod('crm.deal.list', array());
        $rows = array();

        foreach ($listDeal['result'] as $item) {
            $user = callMethod('user.get', array('ID' => $item['ASSIGNED_BY_ID']));
            $user = $user['result']['0']['LAST_NAME'] . ' ' . $user['result']['0']['NAME'];
            $rows[] = array(
                'name' => $item['TITLE'],
                'date' => date('d.m.Y', strtotime($item['BEGINDATE'])),
                'responsible' => $user,
                'amount' => $item['OPPORTUNITY']
            );
        }
        
        echo json_encode($rows);
        break;
    case 'user-list':
        $users = callMethod('user.get', array());
        $userList = array();
        foreach ($users['result'] as $item){
            $userList[] = array(
                'id' => $item['ID'],
                'name' => $item['LAST_NAME'] . ' ' . $item['NAME']
            );
        }
        echo json_encode($userList);
        break;
    case 'filter-table':
        $filter = array();
        $f1 = array();
        $f2 = array();
        if($_POST['dateStart'] && $_POST['dateEnd']){
            $f1 = array('>=BEGINDATE' => $_POST['dateStart'], '<=BEGINDATE' => $_POST['dateEnd']);
        }
        if($_POST['userSelect'] != 0){
            $f2 = array('ASSIGNED_BY_ID' => $_POST['userSelect']);
        }
        $filter = array_merge($f1, $f2);

        $listDeal = callMethod('crm.deal.list', array('filter' => $filter));

        $rows = array();

        foreach ($listDeal['result'] as $item) {
            $user = callMethod('user.get', array('ID' => $item['ASSIGNED_BY_ID']));
            $user = $user['result']['0']['LAST_NAME'] . ' ' . $user['result']['0']['NAME'];
            $rows[] = array(
                'name' => $item['TITLE'],
                'date' => date('d.m.Y', strtotime($item['BEGINDATE'])),
                'responsible' => $user,
                'amount' => $item['OPPORTUNITY']
            );
        }

        echo json_encode($rows);
        break;
}