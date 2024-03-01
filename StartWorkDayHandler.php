//Обработчик на запуск рабочего дня
<?php
AddEventHandler("timeman", "OnAfterTMDayStart", "startWorkDay");

function startWorkDay()
{
	global $USER;

	$user = CUSER::GetByID($USER->GetID());

	$userDepartments = $user->Fetch()["UF_DEPARTMENT"]; // Получаем список департаментов, в которых состоит пользователь

	$departments = CIntranetUtils::getSubDepartments(1); // Получаем список подчиненных департаментов

	foreach($departments as $id) {
		if (in_array($id,  $userDepartments)) {           // Проверяем содержаится ли сотрудник в нужном департаменте

			$arErrorsTmp = array();

			$wfId = CBPDocument::StartWorkflow(              // Запускаем Бизнес процесс
				21,
				array("lists", "BizprocDocument", 33),
				array("user_id" => $USER->GetID()),
				$arErrorsTmp
			);
			break;
		}
	};
}
?>
