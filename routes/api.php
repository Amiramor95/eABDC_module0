<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommandController;
use App\Http\Controllers\ManageModuleController;
use App\Http\Controllers\SettingSmsController;
use App\Http\Controllers\SubModulesController;
use App\Http\Controllers\ManageSubmoduleController;
use App\Http\Controllers\ManageScreenController;
use App\Http\Controllers\SettingDashboardChartController;
use App\Http\Controllers\SettingGeneralController;
use App\Http\Controllers\ManageFormTemplateController;
use App\Http\Controllers\FiMMUserController;
use App\Http\Controllers\SettingEmailController;
use App\Http\Controllers\SettingLdapController;
use App\Http\Controllers\SettingCalendarController;
use App\Http\Controllers\DemoController;
use App\Http\Controllers\ManageEventController;
use App\Http\Controllers\ManageDivisionController;
use App\Http\Controllers\ManageRequiredDocumentController;
use App\Http\Controllers\ManageDepartmentController;
use App\Http\Controllers\ManageGroupController;
use App\Http\Controllers\ManageScreenAccessController;
use App\Http\Controllers\FinanceAccCodeController;
use App\Http\Controllers\DistributorTypeController;
use App\Http\Controllers\ConsultantTypeController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\SettingPostalController;
use App\Http\Controllers\SettingCityController;
use App\Http\Controllers\SmsTacController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ApprovalLevelController;
use App\Http\Controllers\CpdModulePointController;
use App\Http\Controllers\CPDWaiverController;
use App\Http\Controllers\CpdRenewalCalcController;
use App\Http\Controllers\CpdRuleCalcController;
use App\Http\Controllers\CpdSettingController;
use App\Http\Controllers\CpdCutOffDateController;
use App\Http\Controllers\FinanceAccGlcodeController;
use App\Http\Controllers\SettingPasswordController;
use App\Http\Controllers\DistributorApprovalController;
use App\Http\Controllers\AuthorizationLevelController;
use App\Http\Controllers\SideBarController;
use App\Http\Controllers\PendingTaskController;
use App\Http\Controllers\DistApprovalLevelController;
use App\Http\Controllers\DistributorSettingController;
use App\Http\Controllers\AnnualFeesDateController;
use App\Http\Controllers\TaskStatusController;
use App\Http\Controllers\TrModeController;
use App\Http\Controllers\FiveModuleTrModeController;
use App\Http\Controllers\ReadingTrModeController;
use App\Http\Controllers\LsAssessmentController;
use App\Http\Controllers\LsMediaController;
use App\Http\Controllers\LsMethodController;
use App\Http\Controllers\QrModeController;
use App\Http\Controllers\FpCodeController;
use App\Http\Controllers\TrProgramTypeController;
use App\Http\Controllers\ModuleCodeController;
use App\Http\Controllers\RnaVerificationPeriodController;
use App\Http\Controllers\ConsultantDesignationExemptionController;
use App\Http\Controllers\ConsultantQualificationController;
use App\Http\Controllers\ConsultantAppealController;
use App\Http\Controllers\ConsultantBankruptcyController;
use App\Http\Controllers\ConsultantAppealExaminationController;
use App\Http\Controllers\ConsultantExamSessionController;
use App\Http\Controllers\ConsultantTerminationTypeController;
use App\Http\Controllers\ConsultantTypeOfApplicationController;
use App\Http\Controllers\ConsultantActiveCeilliLicenseController;
use App\Http\Controllers\ConsultantPrsFamiliarisationController;
use App\Http\Controllers\ConsultantExaminationTypeController;
use App\Http\Controllers\ConsultantRenewalDateController;
use App\Http\Controllers\FmsFundcategoryController;
use App\Http\Controllers\FmsFundtypeController;
use App\Http\Controllers\FmsFundgroupController;
use App\Http\Controllers\FmsFundnotesController;
use App\Http\Controllers\FmsFundDomicileController;
use App\Http\Controllers\FmsSchemeStructureController;
use App\Http\Controllers\FmsRemarkOptionController;
use App\Http\Controllers\FmsReasonOptionController;
use App\Http\Controllers\FmsCutoffTimeController;
use App\Http\Controllers\DistributorFeeController;
use App\Http\Controllers\WaiverFeeController;
use App\Http\Controllers\ConsultantFeeController;
use App\Http\Controllers\AnnualFeeInvoiceController;
use App\Http\Controllers\FmsUmbrellaFundController;
use App\Http\Controllers\LoginSettingController;
use App\Http\Controllers\SystemBlockDurationController;
use App\Http\Controllers\LoginIdleSessionController;
use App\Http\Controllers\PasswordHistoryController;
use App\Http\Controllers\PasswordDefaultController;
use App\Http\Controllers\SettingUseridController;
use App\Http\Controllers\DistributorManageGroupController;
use App\Http\Controllers\DistributorManageModuleController;
use App\Http\Controllers\DistributorManageSubmoduleController;
use App\Http\Controllers\DistributorScreenAccessController;
use App\Http\Controllers\DistributorManageScreenController;
use App\Http\Controllers\ConsultantManageGroupController;
use App\Http\Controllers\ConsultantManageModuleController;
use App\Http\Controllers\ConsultantManageSubmoduleController;
use App\Http\Controllers\ConsultantManageScreenController;
use App\Http\Controllers\ThirdpartyManageGroupController;
use App\Http\Controllers\ThirdpartyManageModuleController;
use App\Http\Controllers\ThirdpartyManageSubmoduleController;
use App\Http\Controllers\ThirdPartyManageScreenController;
use App\Http\Controllers\TpManageGroupController;
use App\Http\Controllers\TpManageModuleController;
use App\Http\Controllers\TpManageSubmoduleController;
use App\Http\Controllers\TpManageScreenController;
use App\Http\Controllers\CasLetterController;
use App\Http\Controllers\ConsultantScreenAccessController;
use App\Http\Controllers\ThirdpartyScreenAccessController;
use App\Http\Controllers\TpScreenAccessController;
use App\Http\Controllers\PageMaintenanceController;
use App\Http\Controllers\CircularEventController;
use App\Http\Controllers\ManageEventApprovalController;
use App\Http\Controllers\ManageEventDocumentController;
use App\Http\Controllers\CircularEventDocumentController;
use App\Http\Controllers\CircularEventApprovalController;
use App\Http\Controllers\DistributorApprovalLevelController;
use App\Http\Controllers\FileSizeSettingController;
use App\Http\Controllers\DeclarationSettingController;
use App\Http\Controllers\CpdWaiverReasonController;
use App\Http\Controllers\TrainingProviderIdMaskingController;
use App\Http\Controllers\ColourTemplateSettingController;
use App\Http\Controllers\SettingHttpController;
use App\Http\Controllers\UserActiveInactiveController;
use App\Http\Controllers\PurgeDataController;
use App\Http\Controllers\UserManageController;
use App\Http\Controllers\UserMatrixRoleController;
use App\Http\Controllers\ConsultantBulkUploadController;
use App\Http\Controllers\ConsultantPrsFormerFamiliarisationController;
use App\Http\Controllers\DashboardMainSettingController;
use App\Http\Controllers\DashboardChartTypeController;
use App\Http\Controllers\DataRetentionController;
use App\Http\Controllers\CpdRevocationApprovalDaysController;
use App\Http\Controllers\DashboardCpdDisplaySettingController;
use App\Http\Controllers\DashboardCasDisplaySettingController;
use App\Http\Controllers\DashboardFmsDisplaySettingController;
use App\Http\Controllers\DashboardAdminDisplaySettingController;
use App\Http\Controllers\SystemInformationAdminController;
use App\Http\Controllers\DashboardConsultantDisplaySettingController;
use App\Http\Controllers\DashboardFinanceDisplaySettingController;
use App\Http\Controllers\DashboardAnnualDisplaySettingController;
use App\Http\Controllers\BankruptcyController;
use App\Http\Controllers\DashboardDistributorDisplaySettingController;
use App\Http\Controllers\CpdModuleController;
use App\Http\Controllers\FinanceReportController;
use App\Http\Controllers\AdminReportController;
use App\Http\Controllers\ConsultantManagementReportController;
use App\Http\Controllers\DistributorManagementReportController;
use App\Http\Controllers\FundManagementReportController;
use App\Http\Controllers\AnnualFeesReportController;
use App\Http\Controllers\DashboardMainDisplaySettingController;
use App\Http\Controllers\DistributorIdMaskingController;
use App\Http\Controllers\ConsultantIdMaskingController;
use App\Http\Controllers\AuditTrailSettingController;
use Illuminate\Support\Facades\Route;

// Route::group(['middleware' => 'auth:api'], function () {
Route::group(['tag' => 'Demo'], function () {
    Route::post('demo-createuser', [DemoController::class, 'createuser'])->name('Create User');
    Route::post('demo-upload', [DemoController::class, 'uploadFile'])->name('Upload file/s');
    Route::post('demo-assign-group', [DemoController::class, 'assigngroup'])->name('Assign group');
    Route::get('demo-join', [DemoController::class, 'join'])->name('Join data');
    Route::get('demo-data', [DemoController::class, 'getRequest'])->name('Get data');
    Route::get('demo-read-notification', [DemoController::class, 'getNotification'])->name('Get notification');
    Route::post('demo-reset-password', [DemoController::class, 'resetPassword'])->name('Demo Reset Password');
    Route::post('dummy_distributor', [DemoController::class, 'createDummyDistributor'])->name('Create Dummy distributor');
    Route::get('get_dummy_distributor', [DemoController::class, 'getDummyDistributor'])->name('Get All Dummy distributor');
    Route::post('dummy_distributor_delete', [DemoController::class, 'deleteDummyDistributor'])->name('Delete  Dummy distributor');
    Route::post('dummy_distributor_update', [DemoController::class, 'updateDummyDistributor'])->name('Update  Dummy distributor');
});
// });

    Route::post('login', [AuthController::class, 'login'])->name('login');

        Route::get('logout', [AuthController::class, 'logout'])->name('Logout User By Id');
        Route::get('getToken', [AuthController::class, 'getTokenInfo'])->name('Get token info');
        Route::get('checkTokenValidation', [AuthController::class, 'checkTokenValidation'])->name('Check token validation');


    Route::group(['tag' => 'Authorization Level'], function () {
        Route::get('authorization_level', [AuthorizationLevelController::class, 'get'])->name('Get authorization level');
        Route::get('authorization_levels', [AuthorizationLevelController::class, 'getAll'])->name('Get all modules');
        Route::post('authorization_level', [AuthorizationLevelController::class, 'create'])->name('Create authorization_level');
        Route::put('authorization_level', [AuthorizationLevelController::class, 'update'])->name('Update authorization_level');
        Route::delete('authorization_level', [AuthorizationLevelController::class, 'delete'])->name('Delete authorization_level');
    });

    Route::group(['tag' => 'Sidebar'], function () {
        Route::get('sidebar', [SideBarController::class, 'getSideBarByGroupId'])->name('Get sidebar by group Id');
    });

    Route::group(['tag' => 'Command'], function () {
        Route::get('data-seeder', [CommandController::class, 'seedData'])->name('Seed Data');
    });

    Route::group(['tag' => 'Pending Task'], function () {
        Route::get('pending-task', [PendingTaskController::class, 'get'])->name('Get pending task');
    });

    Route::group(['tag' => 'Chart'], function () {
        Route::post('dashboard', [SettingDashboardChartController::class, 'getChart'])->name('Generate chart');
    });

    Route::group(['tag' => 'FiMM User'], function () {
        Route::get('fimm_user/{login_id}', [FiMMUserController::class, 'get'])->name('Get FiMM User by Id');
        Route::get('fimm_users', [FiMMUserController::class, 'getAll'])->name('Get All FiMM User');
        Route::post('fimm_user', [FiMMUserController::class, 'create'])->name('Create FiMM User');
        Route::put('fimm_user', [FiMMUserController::class, 'update'])->name('Update FiMM User');
        Route::delete('fimm_user/{login_id}', [FiMMUserController::class, 'delete'])->name('Delete FiMM User by Id');
        Route::get('get_fimm_login_status', [FiMMUserController::class, 'getLoginStatus'])->name('Get User Login Status');
    });

    Route::group(['tag' => 'Module'], function () {
        //Route::get('module/{id}', [ManageModuleController::class, 'get'])->name('Get module by Id');
        Route::get('module', [ManageModuleController::class, 'get'])->name('Get all modules');
        Route::get('modules', [ManageModuleController::class, 'getAll'])->name('Get all modules');
        Route::post('module', [ManageModuleController::class, 'create'])->name('Create module');
        Route::put('module', [ManageModuleController::class, 'update'])->name('Update module');
        Route::delete('module', [ManageModuleController::class, 'delete'])->name('Delete module');
        Route::get('modulesbytype', [ManageModuleController::class, 'getAllByType'])->name('Get all modules');
    });

    Route::group(['tag' => 'Submodule'], function () {
        Route::post('submodule', [ManageSubmoduleController::class, 'create'])->name('Create submodule from module Id');
        Route::get('submodule', [ManageSubmoduleController::class, 'get'])->name('Get submodule by Id');
        Route::get('submoduless', [ManageSubmoduleController::class, 'getSubmodule'])->name('Get submodule by Id');
        Route::get('submodules', [ManageSubmoduleController::class, 'getAll'])->name('Get all submodules');
        Route::get('submodulesrequire', [ManageSubmoduleController::class, 'getAllSubRequire'])->name('Get all submodules');


        // Route::delete('submodule/{moduleId}', [ManageSubmoduleController::class, 'delete'])->name('Delete submodule by module Id');
        Route::delete('submodule', [ManageSubmoduleController::class, 'delete'])->name('Delete submodule by module Id');
        Route::put('submodule', [ManageSubmoduleController::class, 'update'])->name('Update submodule');
    });

    Route::group(['tag' => 'Screen'], function () {
        Route::post('screen', [ManageScreenController::class, 'create'])->name('Create screen');
        Route::get('screen', [ManageScreenController::class, 'get'])->name('Get screen by module/submodule Id');
        Route::get('screen_byId', [ManageScreenController::class, 'getScreenId'])->name('Get screen by module/submodule Id');
        Route::get('screen_processFlow', [ManageScreenController::class, 'getProcessFlow'])->name('Get screen by module/submodule Id');
        Route::get('screen_submodule', [ManageScreenController::class, 'getSubmodule'])->name('Get screen by module/submodule Id');
        Route::get('screens', [ManageScreenController::class, 'getAll'])->name('Get all submodules');
        Route::delete('screen', [ManageScreenController::class, 'delete'])->name('Delete submodule by module Id');
        Route::put('screen', [ManageScreenController::class, 'update'])->name('Update submodule');
    });

    Route::group(['tag' => 'Screen Access'], function () {
        Route::get('screen_access', [ManageScreenAccessController::class, 'get'])->name('Get screen access by Id');
        Route::get('screen_access_user', [ManageScreenAccessController::class, 'getUser'])->name('Get screen access by Id');
        Route::get('screen_accesses', [ManageScreenAccessController::class, 'getAll'])->name('Get all screen access');
        Route::post('screen_access', [ManageScreenAccessController::class, 'create'])->name('Create screen access');
        Route::put('screen_access', [ManageScreenAccessController::class, 'update'])->name('Update screen Access');
        Route::get('screen_access_auth', [ManageScreenAccessController::class, 'getAuthorization'])->name('Get screen access by Id');
        Route::get('screen_access_group', [ManageScreenAccessController::class, 'getAllGroup'])->name('Get screen access by Id');
        Route::delete('screen_access', [ManageScreenAccessController::class, 'delete'])->name('Delete Screen');
        Route::get('user_additional_screen', [ManageScreenAccessController::class, 'userAdditionalScreen'])->name('Get scree');
        Route::post('save_user_additional_screen', [ManageScreenAccessController::class, 'saveUserAdditionalScreen'])->name('Create');
    });
    Route::group(['tag' => 'User Matrix'], function () {
        Route::get('get_all_user_info', [UserMatrixRoleController::class, 'getAllUserInfo'])->name('Get All User');
        Route::get('get_user_matrix_screen', [UserMatrixRoleController::class, 'getUserMatrixScreen'])->name('Get All User');
        Route::post('save_user_role_matrix', [UserMatrixRoleController::class, 'saveUserRoleMatrix'])->name('Save Role');
    });

    Route::group(['tag' => 'Notification'], function () {
        Route::get('notifications', [NotificationController::class, 'get'])->name('Get notifications');
        Route::post('update_notifications', [NotificationController::class, 'update'])->name('Get Distributor notifications');
        Route::get('distributor_notifications', [NotificationController::class, 'getDistributor'])->name('Get Distributor notifications');
        Route::post('update_distributor_notifications', [NotificationController::class, 'updateDistributor'])->name('Get Distributor notifications');
        Route::get('notifications_by_group_and_module', [NotificationController::class, 'getByModuleAndGroupId'])->name('Get Csonsultant notifications');
        Route::get('consultant_notifications', [NotificationController::class, 'getConsultant'])->name('Get Consultant notifications');
        Route::post('update_consultant_notifications', [NotificationController::class, 'updateConsultant'])->name('Delete Consultant notifications on Click');
        Route::get('others_notifications', [NotificationController::class, 'getDistributor'])->name('Get Distributor notifications');
        Route::post('update_others_notifications', [NotificationController::class, 'updateDistributor'])->name('Get Distributor notifications');
    });

    Route::group(['tag' => 'Template'], function () {
        Route::get('template', [ManageFormTemplateController::class, 'get'])->name('Get template by Id');
        Route::get('templates', [ManageFormTemplateController::class, 'getAll'])->name('Get all templates');
        Route::post('template', [ManageFormTemplateController::class, 'create'])->name('Create template');
        Route::get('template_file', [ManageFormTemplateController::class, 'getFile'])->name('Get template file by template Id');
        Route::delete('template_file', [ManageFormTemplateController::class, 'delete'])->name('Delete template file by template file Id');
        Route::post('template_file', [ManageFormTemplateController::class, 'update'])->name('Update template');
        Route::get('download/template_file', [ManageFormTemplateController::class, 'fileDownload'])->name('Download template');
        Route::post('filter_template', [ManageFormTemplateController::class, 'filter'])->name('Filter template');
        Route::get('download/template_file1', [ManageFormTemplateController::class, 'fileDownload1'])->name('Download template');
    });

    Route::group(['tag' => 'SMS Integration'], function () {
        Route::get('sms_setting', [SettingSmsController::class, 'get'])->name('Get SMS setting');
        Route::get('sms_record', [SettingSmsController::class, 'getLog'])->name('Get SMS log record');
        Route::post('sms_setting_update', [SettingSmsController::class, 'manage'])->name('Manage SMS setting');
        Route::post('sms_setting_create', [SettingSmsController::class, 'create'])->name('Create SMS setting');
        Route::post('sms_testing', [SettingSmsController::class, 'test'])->name('SMS testing');
        Route::post('sms', [SettingSmsController::class, 'send'])->name('Send SMS');
        Route::post('sms_TAC', [SmsTacController::class, 'getTAC'])->name('Get TAC');
        Route::get('sms_verify_TAC', [SmsTacController::class, 'verifyTAC'])->name('Verify TAC');
        Route::post('sms_setting_test', [SettingSmsController::class, 'testConnection'])->name('SMS testing');
    });
    Route::group(['tag' => 'HTTP Setting'], function () {
        Route::get('http_setting', [SettingHttpController::class, 'get'])->name('Get Http setting');
        Route::post('http_setting_update', [SettingHttpController::class, 'update'])->name('Update Http setting');
        Route::post('http_setting_create', [SettingHttpController::class, 'create'])->name('Create Http setting');
    });

    Route::group(['tag' => 'Email Integration'], function () {
        Route::get('email_setting', [SettingEmailController::class, 'get'])->name('Get email setting');
        Route::post('email_setting', [SettingEmailController::class, 'manage'])->name('Manage email setting');
        Route::post('email_setting_update', [SettingEmailController::class, 'update'])->name('Update email setting');
        Route::post('email_setting_test', [SettingEmailController::class, 'testConnection'])->name('Test email setting');
        Route::post('email', [SettingEmailController::class, 'send'])->name('Send Email');
    });

    Route::group(['tag' => 'LDAP Integration'], function () {
        Route::get('ldap_setting', [SettingLdapController::class, 'get'])->name('Get LDAP setting');
        Route::post('ldap_setting', [SettingLdapController::class, 'manage'])->name('Manage LDAP setting');
        Route::post('ldap_setting_create', [SettingLdapController::class, 'create'])->name('Create LDAP setting');
        Route::post('ldap_setting_update', [SettingLdapController::class, 'update'])->name('Update LDAP setting');
        Route::post('ldap_testing', [SettingLdapController::class, 'test'])->name('LDAP testing');
        Route::post('ldap_sync', [SettingLdapController::class, 'sync'])->name('Sync Users from Active Directory');
    });
    Route::group(['tag' => 'File Size Setting'], function () {
        Route::get('file_size_setting', [FileSizeSettingController::class, 'get'])->name('Get File Size setting');
        Route::post('filesize_setting_create', [FileSizeSettingController::class, 'create'])->name('Create File Size setting');
        Route::post('file_size_setting_update', [FileSizeSettingController::class, 'update'])->name('Update File Size setting');
    });

    Route::group(['tag' => 'Calendar Setting'], function () {
        Route::post('calendar_setting', [SettingCalendarController::class, 'create'])->name('Create Calendar setting');
        Route::post('multi_calendar_setting', [SettingCalendarController::class, 'create_multi_cal'])->name('Create Multiple Calendar setting');
        Route::get('calendar_settings', [SettingCalendarController::class, 'getAll'])->name('Get all exception');
        Route::get('calendar_setting_ById', [SettingCalendarController::class, 'get'])->name('Get Exception by Id');
        Route::delete('calendar_setting', [SettingCalendarController::class, 'delete'])->name('Delete exception');
        Route::post('calendar_setting_update', [SettingCalendarController::class, 'update'])->name('Update exception');
        Route::get('filter_calendar_setting', [SettingCalendarController::class, 'filter'])->name('Search exception');
    });

    Route::group(['tag' => 'Event Management'], function () {
        Route::post('create_event_management', [ManageEventController::class, 'create'])->name('Create Event');
        Route::post('event_management', [ManageEventController::class, 'update'])->name('Update Event');
        Route::get('event_managements', [ManageEventController::class, 'getAll'])->name('Get all event');
        Route::get('event_management', [ManageEventController::class, 'get'])->name('Get event by Id');
        Route::delete('event_management', [ManageEventController::class, 'delete'])->name('Delete');
        Route::get('search_annouce_management', [ManageEventController::class, 'searchAnnouceManagement'])->name('Get all event');
        Route::get('announcement_by_id', [ManageEventController::class, 'getAnnById'])->name('Get event by Id');
        Route::post('event_management_delete', [ManageEventController::class, 'delete'])->name('Delete');
        Route::get('review_announcement', [ManageEventController::class, 'getAllReviewAnnouncement'])->name('Get Review');
        Route::post('review_event_update', [ManageEventController::class, 'reviewAnnouncementUpdate'])->name('Create Event');
        Route::post('set_announcement_status', [ManageEventController::class, 'setAnnounceStatus'])->name('Set Status');
        Route::get('get_announce_dept', [ManageEventController::class, 'getAnnounceDepartment'])->name('Get all department');
        Route::get('get_announcement_by_dept_id', [ManageEventController::class, 'getAnnounceByDepartment'])->name('Get all department');
        Route::get('event_management_department', [ManageEventController::class, 'getAllDepartment'])->name('Get all event');
    });
    Route::group(['tag' => 'Event Management Document'], function () {
        Route::get('event_document', [ManageEventDocumentController::class, 'get'])->name('Get all event');
    });
    Route::group(['tag' => 'Event Management Approval'], function () {
        Route::post('event_approval', [ManageEventApprovalController::class, 'create'])->name('Create Event');
        Route::put('event_approval', [ManageEventApprovalController::class, 'update'])->name('Update Event');
        Route::get('event_approvals', [ManageEventApprovalController::class, 'getAll'])->name('Get all event');
        Route::get('event_approval', [ManageEventApprovalController::class, 'get'])->name('Get event by Id');
        Route::get('event_approvalss', [ManageEventApprovalController::class, 'getApprList'])->name('Get event by Id');
        Route::post('delete_event_appr', [ManageEventApprovalController::class, 'delete'])->name('Delete');
    });
    Route::group(['tag' => 'Circular Management'], function () {
        Route::post('create_circular_management', [CircularEventController::class, 'createNewCircular'])->name('Create New Circular');
        Route::post('update_circular_management', [CircularEventController::class, 'updateNewCircular'])->name('Update Circular');
        Route::post('delete_circular_management', [CircularEventController::class, 'circularDelete'])->name('Delete Circular');
        Route::put('circular_management', [CircularEventController::class, 'update'])->name('Update circular');
        Route::get('circular_managements', [CircularEventController::class, 'getAll'])->name('Get all circular');
        Route::get('circular_by_id', [CircularEventController::class, 'get'])->name('Get event by Id');
        Route::delete('circular_management', [CircularEventController::class, 'delete'])->name('Delete');
        Route::get('search_circular', [CircularEventController::class, 'searchCircular'])->name('Get all event');
        Route::get('review_circular', [CircularEventController::class, 'getAllReviewCircular'])->name('Get Review');
        Route::post('review_circular_update', [CircularEventController::class, 'reviewCircularUpdate'])->name('Get Review');
        Route::get('gm_review_circular', [CircularEventController::class, 'getGmReviewCircular'])->name('Get Review');
        Route::post('gm_review_circular_update', [CircularEventController::class, 'gmReviewCircularUpdate'])->name('Get Review');
        Route::post('set_circular_status', [CircularEventController::class, 'setCircularStatus'])->name('Set Status');
        Route::get('get_circular_dept', [CircularEventController::class, 'getCircularDepartment'])->name('Get all department');
        Route::get('get_circular_by_dept_id', [CircularEventController::class, 'getCircularByDepartmentID'])->name('Get Circular By  department');
        Route::get('get_dept_name', [CircularEventController::class, 'getDepartment'])->name('Get Circular By  department');
        Route::get('circular_management_fimm', [CircularEventController::class, 'getAllApproved'])->name('Get all circular');
    });
    Route::group(['tag' => 'Circular Document'], function () {
        Route::get('circular_document', [CircularEventDocumentController::class, 'get'])->name('Get all event');
    });
    Route::group(['tag' => 'Circular Approval'], function () {
        Route::get('circular_approval', [CircularEventApprovalController::class, 'CirculargetApprList'])->name('Get all event');
    });
    Route::group(['tag' => 'Task Status'], function () {
        Route::get('get_task_status', [CircularEventApprovalController::class, 'getTaskStatus'])->name('Get all status');
        Route::get('get_active_inactive_task_status', [TaskStatusController::class, 'getActiveInactiveTaskStatus'])->name('Get active and inactive status');
    });

    Route::group(['tag' => 'Division Management'], function () {
        Route::post('division_management', [ManageDivisionController::class, 'create'])->name('Create Division');
        Route::get('division_managements', [ManageDivisionController::class, 'getAll'])->name('Get all division');
        Route::get('division_management', [ManageDivisionController::class, 'get'])->name('Get division by Id');
        Route::delete('division_management', [ManageDivisionController::class, 'delete'])->name('Delete division');
        Route::put('division_management', [ManageDivisionController::class, 'update'])->name('Update division');
    });
    Route::group(['tag' => 'Department Management'], function () {
        Route::post('department_management', [ManageDepartmentController::class, 'create'])->name('Create department');
        Route::get('department_managements', [ManageDepartmentController::class, 'getAll'])->name('Get all department');
        Route::get('department_management', [ManageDepartmentController::class, 'get'])->name('Get department by Id');
        Route::get('department_management_by_division', [ManageDepartmentController::class, 'getByDivision'])->name('Get department by division Id');
        Route::delete('department_management', [ManageDepartmentController::class, 'delete'])->name('Delete department');
        Route::put('department_management', [ManageDepartmentController::class, 'update'])->name('Update department');
        Route::get('filter_department_management', [ManageDepartmentController::class, 'filter'])->name('Filter department');
    });
    Route::group(['tag' => 'Group Management'], function () {
        Route::post('group_management', [ManageGroupController::class, 'create'])->name('Create group');
        Route::get('group_managements', [ManageGroupController::class, 'getAll'])->name('Get all group');
        Route::get('group_management', [ManageGroupController::class, 'get'])->name('Get group by Id');
        Route::delete('group_management', [ManageGroupController::class, 'delete'])->name('Delete group');
        Route::get('group_management_by_department', [ManageGroupController::class, 'getByDepartment'])->name('Get group by department Id');
        Route::put('group_management', [ManageGroupController::class, 'update'])->name('Update group');
        Route::get('get_distributor_group', [ManageGroupController::class, 'getAllDistributorGroup'])->name('Get Distributor Group');
    });
    Route::group(['tag' => 'Required Document'], function () {
        Route::post('required_document', [ManageRequiredDocumentController::class, 'create'])->name('Create required document');
        Route::get('sub_modules', [ManageRequiredDocumentController::class, 'getSubModule'])->name('Get sub module');
        Route::get('doc_type', [ManageRequiredDocumentController::class, 'getDocType'])->name('Get document type');
        Route::get('required_document', [ManageRequiredDocumentController::class, 'getAll'])->name('Get required document');
        Route::get('filter_required_document', [ManageRequiredDocumentController::class, 'filter'])->name('Filter required document');
        Route::delete('required_document', [ManageRequiredDocumentController::class, 'delete'])->name('Delete required document');
        Route::get('required_document_byId', [ManageRequiredDocumentController::class, 'getById'])->name('Get required document by id');
        Route::get('required_document_byEditId', [ManageRequiredDocumentController::class, 'getEditDataById'])->name('Get required document by id');
        Route::post('required_document_update', [ManageRequiredDocumentController::class, 'update'])->name('Update required document');
        Route::get('required_document_proposal', [ManageRequiredDocumentController::class, 'getDocumentProposal'])->name('get required document proposal');
        Route::put('required_document', [ManageRequiredDocumentController::class, 'update'])->name('Update required document');
        Route::get('required_document_additional', [ManageRequiredDocumentController::class, 'getDocumentAdditional'])->name('get required document proposal');
        Route::get('getDocumentProposalData', [ManageRequiredDocumentController::class, 'getDocumentProposalData'])->name('get both required and proposal document proposal data');
        Route::get('getDocumentRequired', [ManageRequiredDocumentController::class, 'getDocumentRequired'])->name('get required document  data');
        Route::get('getDocumentProposalFile', [ManageRequiredDocumentController::class, 'getDocumentProposalFile'])->name('get required document proposal data');
        Route::get('getDocumentDataReview', [ManageRequiredDocumentController::class, 'getDocumentDataReview'])->name('get required document data for review');
    });
    Route::group(['tag' => 'Finance Account Code'], function () {
        Route::post('finance_account_code', [FinanceAccCodeController::class, 'create'])->name('Create Account');
        Route::get('finance_account_code', [FinanceAccCodeController::class, 'getAll'])->name('Get all Account');
        Route::get('finance_account_code', [FinanceAccCodeController::class, 'get'])->name('Get Account by Id');
        // Route::get('finance_account_code', [FinanceAccCodeController::class, 'get'])->name('Get Account by Id');
        Route::get('finance_account_type', [FinanceAccCodeController::class, 'getAccCodeType'])->name('Get Account by Id');
        Route::get('finance_account_name', [FinanceAccCodeController::class, 'getAccCodeName'])->name('Get Account by Id');
        Route::delete('finance_account_code', [FinanceAccCodeController::class, 'delete'])->name('Delete Account Code');
    });
    Route::group(['tag' => 'Finance Setting Code'], function () {
        Route::post('finance_setting_code', [FinanceAccGlcodeController::class, 'create'])->name('Create Setting Code');
        Route::get('finance_setting_codes', [FinanceAccGlcodeController::class, 'getAll'])->name('Get all Setting Code');
        Route::get('finance_setting_code', [FinanceAccGlcodeController::class, 'get'])->name('Get Setting Code by Id');
        Route::delete('finance_setting_code', [FinanceAccGlcodeController::class, 'delete'])->name('Delete Setting Code');
        Route::get('distributor_list', [FinanceAccGlcodeController::class, 'getAllDistributor'])->name('Get all Setting Code');
        Route::get('fin_code_table', [FinanceAccGlcodeController::class, 'getCodeTable'])->name('Get Setting Code by Id');
    });
    Route::group(['tag' => 'Setting General'], function () {
        Route::post('setting_general', [SettingGeneralController::class, 'create'])->name('Create setting');
        Route::get('setting_generals', [SettingGeneralController::class, 'getAll'])->name('Get all setting');
        Route::get('setting_general', [SettingGeneralController::class, 'get'])->name('Get setting by Id');
        Route::delete('setting_general', [SettingGeneralController::class, 'delete'])->name('Delete setting');
        Route::put('setting_general', [SettingGeneralController::class, 'update'])->name('Update setting');
        Route::get('other_type', [SettingGeneralController::class, 'getOtherUserCategory'])->name('Get other user category');
        Route::get('get_state', [SettingGeneralController::class, 'getAllState'])->name('Get All State');
        Route::get('get_states', [SettingGeneralController::class, 'getState'])->name('Get State by ID');
        Route::get('get_all_citizenship', [SettingGeneralController::class, 'getAllCitizenship'])->name('Get State by ID');
        Route::get('get_country', [SettingGeneralController::class, 'getAllCountry'])->name('Get All State');
        Route::get('get_countrys', [SettingGeneralController::class, 'getCountry'])->name('Get State by ID');
        Route::get('filter_setting_general', [SettingGeneralController::class, 'filter'])->name('Search exception');
        Route::post('filter_country', [SettingGeneralController::class, 'filterCountry'])->name('Search Country');
        Route::get('currency_format', [SettingGeneralController::class, 'getCurrency'])->name('get currency format');
        Route::get('getAllCurrencyFormat', [SettingGeneralController::class, 'getAllCurrency'])->name('get allcurrency format');
        Route::post('bulk_upload', [SettingGeneralController::class, 'bulkUpload'])->name('create bulk upload Country');
        Route::post('bulk_upload_country', [SettingGeneralController::class, 'bulkUploadCountry'])->name('bulk upload Country');
        Route::post('bulk_upload_state', [SettingGeneralController::class, 'bulkUploadState'])->name('bulk upload Country');

        // Route::post('bulk_countrylist', [SettingGeneralController::class, 'getCountryList'])->name('create bulk upload');
    });
    Route::group(['tag' => 'Distributor Setting'], function () {
        Route::post('dist_setting', [DistributorSettingController::class, 'create'])->name('Create distributor setting');
        Route::get('dist_settings', [DistributorSettingController::class, 'getAll'])->name('Get all distributor setting');
        Route::get('dist_setting', [DistributorSettingController::class, 'get'])->name('Get distributor setting by Id');
        Route::get('dist_setting_by_id', [DistributorSettingController::class, 'getById'])->name('Get distributor setting by Id');
        Route::delete('dist_setting', [DistributorSettingController::class, 'delete'])->name('Delete distributor setting');
        Route::put('dist_setting', [DistributorSettingController::class, 'update'])->name('Update distributor setting');
        Route::get('dist_declare', [DistributorSettingController::class, 'getAllDeclaration'])->name('Get all distributor Declaration');
        Route::get('dist_appeal', [DistributorSettingController::class, 'getAllAppeal'])->name('Get all distributor Appeal List');
        Route::get('dist_return', [DistributorSettingController::class, 'getAllReturnDuration'])->name('Get all distributor Return List');
        Route::get('dist_appeal_revoke', [DistributorSettingController::class, 'getAppealRevoke'])->name('Get all distributor Appeal List');
    });
    Route::group(['tag' => 'Declaration Setting'], function () {
        Route::post('setting_declaration_create', [DeclarationSettingController::class, 'create'])->name('Create Declaration setting');
        Route::get('declaration_setting', [DeclarationSettingController::class, 'getAll'])->name('Get all Declaration setting');
        Route::post('declaration_setting_update', [DeclarationSettingController::class, 'update'])->name('Update Declaration setting');
        Route::delete('declaration_setting', [DeclarationSettingController::class, 'delete'])->name('Delete Declaration setting');
    });

    Route::group(['tag' => 'Setting Postcode'], function () {
        Route::post('setting_postcode', [SettingPostalController::class, 'create'])->name('Create Postcode');
        Route::get('setting_postcodes', [SettingPostalController::class, 'getAll'])->name('Get all Postcode');
        Route::get('setting_postcode', [SettingPostalController::class, 'get'])->name('Get Postcode by Id');
        // Route::get('setting_postcode', [SettingPostalController::class, 'get'])->name('Get Postcode by Id');
        Route::post('setting_postcode_update', [SettingPostalController::class, 'update'])->name('Update setting Postcode');
        Route::post('filter_setting_postcode', [SettingPostalController::class, 'filter'])->name('Filter');
        Route::delete('setting_postcode', [SettingPostalController::class, 'delete'])->name('Delete setting');
        Route::post('bulk_upload_post_code', [SettingPostalController::class, 'bulkUploadPostalCode'])->name('Bulk Upload Postal Code');
    });
    Route::group(['tag' => 'Setting City'], function () {
        Route::post('setting_city', [SettingCityController::class, 'create'])->name('Create Postcode');
        //Route::get('setting_city', [SettingCityController::class, 'getAll'])->name('Get all Postcode');
        // Route::get('setting_city', [SettingCityController::class, 'get'])->name('Get Postcode by Id');
        Route::put('setting_city', [SettingCityController::class, 'update'])->name('Update setting Postcode');
    });

    Route::group(['tag' => 'Training Provider ID Masking Setting'], function () {
        Route::post('create_masking', [TrainingProviderIdMaskingController::class, 'create'])->name('Create ID Masking');
        Route::get('all_masking', [TrainingProviderIdMaskingController::class, 'getAll'])->name('Get all Masking');
        Route::get('latest_masking', [TrainingProviderIdMaskingController::class, 'getLatest'])->name('Get Latest Masking');
        Route::get('masking_by_id', [TrainingProviderIdMaskingController::class, 'get'])->name('Get Masking by Id');
        Route::put('masking_update', [TrainingProviderIdMaskingController::class, 'update'])->name('Update  Masking');
        Route::delete('masking_delete', [TrainingProviderIdMaskingController::class, 'delete'])->name('Delete Masking');
    });

    Route::group(['tag' => 'Approval Level'], function () {
        Route::post('approval_level', [ApprovalLevelController::class, 'create'])->name('Create Approval Level');
        Route::get('approval_levels', [ApprovalLevelController::class, 'getAll'])->name('Get all Approval Level');
        Route::get('approval_levelss', [ApprovalLevelController::class, 'getAllbyName'])->name('getAllbyName Approval Level');
        Route::get('approval_level', [ApprovalLevelController::class, 'get'])->name('Get Approval Level by Id');
        Route::get('approval_level_byindex', [ApprovalLevelController::class, 'getByIndex'])->name('Get Approval Level by index');
        Route::get('approval_level_by_process_flow', [ApprovalLevelController::class, 'getByProcessFlow'])->name('Get Approval Level by index');
        Route::get('get_department', [ApprovalLevelController::class, 'getAllDepartment'])->name('Get all Department list');
        Route::get('get_distributor', [ApprovalLevelController::class, 'getAllDistibutorType'])->name('Get all Department list');
        Route::put('approval_level', [ApprovalLevelController::class, 'update'])->name('Update Approval Level');
    });
    Route::group(['tag' => 'Distributor Approval Level'], function () {
        Route::post('dist_approval', [DistApprovalLevelController::class, 'create'])->name('Create Postcode');
        Route::get('get_group', [DistApprovalLevelController::class, 'getAllGroup'])->name('Get all Group');
        Route::get('dist_approvals', [DistApprovalLevelController::class, 'getAll'])->name('Get all');
        Route::get('dist_approval', [DistApprovalLevelController::class, 'get'])->name('Get Postcode by Id');
        Route::put('dist_approval', [DistApprovalLevelController::class, 'update'])->name('Update setting Postcode');
    });
    Route::group(['tag' => 'CPD Module Point'], function () {
        Route::get('cpd_point', [CpdModulePointController::class, 'get'])->name('Get Cpd Point');
        Route::get('cpd_points', [CpdModulePointController::class, 'getAll'])->name('Get All Cpd Point');
        Route::get('five_modules', [CpdModulePointController::class, 'getAllfiveModule'])->name('Get All Cpd Point');
        Route::post('cpd_point', [CpdModulePointController::class, 'create'])->name('create Cpd Point');
        Route::put('cpd_point', [CpdModulePointController::class, 'update'])->name('create Cpd Point');
        Route::delete('cpd_point', [CpdModulePointController::class, 'delete'])->name('create Cpd Point'); //
    });
    Route::group(['tag' => 'CPD Waiver'], function () {
        Route::get('cpd_waiver', [CpdWaiverReasonController::class, 'get'])->name('Get CPD Waiver');
        Route::get('cpd_waivers', [CpdWaiverReasonController::class, 'getAll'])->name('Get All CPD Waiver');
        Route::post('cpd_waiver', [CpdWaiverReasonController::class, 'create'])->name('create CPD Waiver');
        Route::put('cpd_waiver', [CpdWaiverReasonController::class, 'update'])->name('Update CPD Waiver');
        Route::delete('cpd_waiver', [CpdWaiverReasonController::class, 'delete'])->name('create CPD Waiver');
    });
    /*Route::group(['tag' => 'CPD Waiver'], function () {
        Route::get('cpd_waiver', [CPDWaiverController::class, 'get'])->name('Get CPD Waiver');
        Route::get('cpd_waivers', [CPDWaiverController::class, 'getAll'])->name('Get All CPD Waiver');
        Route::post('cpd_waiver', [CPDWaiverController::class, 'create'])->name('create CPD Waiver');
        Route::put('cpd_waiver', [CPDWaiverController::class, 'update'])->name('Update CPD Waiver');
        Route::delete('cpd_waiver', [CPDWaiverController::class, 'delete'])->name('create CPD Waiver');
    });*/
    Route::group(['tag' => 'CPD Renewal Calculation'], function () {
        Route::get('cpd_renewal', [CpdRenewalCalcController::class, 'get'])->name('Get cpd renewal');
        Route::get('cpd_renewals', [CpdRenewalCalcController::class, 'getAll'])->name('Get All cpd renewal');
        Route::post('cpd_renewal', [CpdRenewalCalcController::class, 'create'])->name('create cpd renewal');
        Route::put('cpd_renewal', [CpdRenewalCalcController::class, 'update'])->name('create cpd renewal');
        Route::delete('cpd_renewal', [CpdRenewalCalcController::class, 'delete'])->name('create cpd renewal');
    });
    Route::group(['tag' => 'CPD Rule Renewal Calculation'], function () {
        Route::get('cpd_rule', [CPDRuleCalcController::class, 'get'])->name('Get cpd rule');
        Route::get('cpd_rules', [CPDRuleCalcController::class, 'getAll'])->name('Get All cpd rule');
        Route::post('cpd_rule', [CPDRuleCalcController::class, 'create'])->name('create cpd rule');
        Route::put('cpd_rule', [CPDRuleCalcController::class, 'update'])->name('Update cpd rule');
        Route::delete('cpd_rule', [CPDRuleCalcController::class, 'delete'])->name('create cpd rule');
    });
    Route::group(['tag' => 'CPD Setting'], function () {
        Route::get('cpd_setting', [CpdSettingController::class, 'get'])->name('Get cpd setting');
        Route::get('cpd_settings', [CpdSettingController::class, 'getAll'])->name('Get All cpd setting');
        Route::post('cpd_setting', [CpdSettingController::class, 'create'])->name('create cpd setting');
        Route::put('cpd_setting', [CpdSettingController::class, 'update'])->name('create cpd setting');
        Route::delete('cpd_setting', [CpdSettingController::class, 'delete'])->name('create cpd setting');
    });
    Route::group(['tag' => 'CPD Cut Off Date'], function () {
        Route::get('cpd_dates', [CpdCutOffDateController::class, 'get'])->name('Get cpd cut of date');
        Route::get('cpd_date', [CpdCutOffDateController::class, 'getAll'])->name('Get All cpd cut of date');
        Route::post('cpd_date', [CpdCutOffDateController::class, 'create'])->name('create cpd cut of date');
        Route::put('cpd_date', [CpdCutOffDateController::class, 'update'])->name('create cpd cut of date');
        Route::delete('cpd_date', [CpdCutOffDateController::class, 'delete'])->name('create cpd cut of date');
    });
    Route::group(['tag' => 'Annual Fee Date'], function () {
        Route::post('annual_date', [AnnualFeesDateController::class, 'create'])->name('Create Annual fee Date');
        Route::get('annual_date', [AnnualFeesDateController::class, 'getAll'])->name('Get all Annual fee Date');
        Route::get('annual_dates', [AnnualFeesDateController::class, 'get'])->name('Get Annual fee Date by Id');
        Route::get('annual_date_by_id', [AnnualFeesDateController::class, 'getbyId'])->name('Get Annual fee Date by Id');
        Route::get('annual_datess', [AnnualFeesDateController::class, 'getAllListDate'])->name('Get all Annual fee Date');
        Route::put('annual_date', [AnnualFeesDateController::class, 'update'])->name('create Annual fee Date');
    });
    Route::group(['tag' => 'R&A VERIFICATION DATE'], function () {
        Route::post('rna_date', [RnaVerificationPeriodController::class, 'create'])->name('Create  Date');
        Route::get('rna_dates', [RnaVerificationPeriodController::class, 'getAll'])->name('Get all Date');
        // Route::get('annual_dates', [AnnualFeesDateController::class, 'get'])->name('Get Annual fee Date by Id');
        // Route::get('annual_datess', [AnnualFeesDateController::class, 'getAllListDate'])->name('Get all Annual fee Date');
    });

    Route::group(['tag' => 'Distributor Type'], function () {
        Route::get('distributor_types', [DistributorTypeController::class, 'getAll'])->name('Get all distributor type');
        Route::get('distributor_type', [DistributorTypeController::class, 'get'])->name('Get all distributor type');
        Route::get('distributor_typess', [DistributorTypeController::class, 'getDistType'])->name('Get all distributor type');
        Route::post('distributor_type', [DistributorTypeController::class, 'create'])->name('create dist Type');
        Route::post('distributor_type_update', [DistributorTypeController::class, 'update'])->name('Update Dist Type');
        Route::delete('distributor_type', [DistributorTypeController::class, 'delete'])->name('Delete Dist Type');
        Route::get('dist_marketing', [DistributorTypeController::class, 'getMarketing'])->name('Get all marketing list');
        Route::get('consultant_type', [DistributorTypeController::class, 'getConsultantType'])->name('Get all Consultant type');
        Route::get('distributor_type_by_id', [DistributorTypeController::class, 'getDisTypeByID'])->name('Get all distributor type');
        Route::get('dummy_distributor_type', [DistributorTypeController::class, 'getDummyType'])->name('Get all distributor type');
    });
    Route::group(['tag' => 'TR Mode Pre and Post vetting'], function () {
        Route::get('tr_modess', [TrModeController::class, 'getAll'])->name('Get all TR Mode Pre and Post vetting');
        Route::get('tr_mode', [TrModeController::class, 'get'])->name('Get TR Mode Pre and Post vetting');
        Route::post('tr_mode', [TrModeController::class, 'create'])->name('create TR Mode Pre and Post vetting');
        Route::put('tr_mode', [TrModeController::class, 'update'])->name('create TR Mode Pre and Post vetting');
        Route::delete('tr_mode', [TrModeController::class, 'delete'])->name('create TR Mode Pre and Post vetting');
    });
    Route::group(['tag' => 'TR Mode 5 Module'], function () {
        Route::get('five_trs', [FiveModuleTrModeController::class, 'getAll'])->name('Get all TR 5 Module');
        Route::get('five_tr', [FiveModuleTrModeController::class, 'get'])->name('Get TR Mode 5 Module');
        Route::post('five_tr', [FiveModuleTrModeController::class, 'create'])->name('create TR Mode 5 Module');
        Route::put('five_tr', [FiveModuleTrModeController::class, 'update'])->name('Update TR Mode 5 Module');
        Route::delete('five_tr', [FiveModuleTrModeController::class, 'delete'])->name('Delete TR Mode 5 Module');
    });
    Route::group(['tag' => 'TR Mode Reading'], function () {
        Route::get('reading_trss', [ReadingTrModeController::class, 'getAll'])->name('Get all TR Reading');
        Route::get('reading_tr', [ReadingTrModeController::class, 'get'])->name('Get TR Mode Reading');
        Route::post('reading_tr', [ReadingTrModeController::class, 'create'])->name('create TR Mode Reading');
        Route::put('reading_tr', [ReadingTrModeController::class, 'update'])->name('create TR Mode Reading');
        Route::delete('reading_tr', [ReadingTrModeController::class, 'delete'])->name('create TR Mode Reading');
    });
    Route::group(['tag' => 'LS ASSESSMENT'], function () {
        Route::get('ls_assessments', [LsAssessmentController::class, 'getAll'])->name('Get all LS ASSESSMENT');
        Route::get('ls_assessment', [LsAssessmentController::class, 'get'])->name('Get LS ASSESSMENT');
        Route::post('ls_assessment', [LsAssessmentController::class, 'create'])->name('create LS ASSESSMENT');
        Route::put('ls_assessment', [LsAssessmentController::class, 'update'])->name('update LS ASSESSMENT');
        Route::delete('ls_assessment', [LsAssessmentController::class, 'delete'])->name('create LS ASSESSMENT');
    });
    Route::group(['tag' => 'LS MEDIA'], function () {
        Route::get('ls_medias', [LsMediaController::class, 'getAll'])->name('Get all LS MEDIA');
        Route::get('ls_media', [LsMediaController::class, 'get'])->name('Get LS MEDIA');
        Route::post('ls_media', [LsMediaController::class, 'create'])->name('create LS MEDIA');
        Route::put('ls_media', [LsMediaController::class, 'update'])->name('update LS MEDIA');
        Route::delete('ls_media', [LsMediaController::class, 'delete'])->name('create LS MEDIA');
    });
    Route::group(['tag' => 'LS METHOD'], function () {
        Route::get('ls_methods', [LsMethodController::class, 'getAll'])->name('Get all LS METHOD');
        Route::get('ls_method', [LsMethodController::class, 'get'])->name('Get LS METHOD');
        Route::post('ls_method', [LsMethodController::class, 'create'])->name('create LS METHOD');
        Route::put('ls_method', [LsMethodController::class, 'update'])->name('update LS METHOD');
        Route::delete('ls_method', [LsMethodController::class, 'delete'])->name('create LS METHOD');
    });
    Route::group(['tag' => 'QR MODE'], function () {
        Route::get('qr_modes', [QrModeController::class, 'getAll'])->name('Get all QR MODE');
        Route::get('qr_mode', [QrModeController::class, 'get'])->name('Get QR MODE');
        Route::post('qr_mode', [QrModeController::class, 'create'])->name('create QR MODE');
        Route::put('qr_mode', [QrModeController::class, 'update'])->name('update QR MODE');
        Route::delete('qr_mode', [QrModeController::class, 'delete'])->name('create QR MODE');
    });
    Route::group(['tag' => 'FP CODE'], function () {
        Route::get('fp_codes', [FpCodeController::class, 'getAll'])->name('Get all FP CODE');
        Route::get('fp_code', [FpCodeController::class, 'get'])->name('Get FP CODE');
        Route::post('fp_code', [FpCodeController::class, 'create'])->name('create FP CODE');
        Route::put('fp_code', [FpCodeController::class, 'update'])->name('update FP CODE');
        Route::delete('fp_code', [FpCodeController::class, 'delete'])->name('create FP CODE');
    });
    Route::group(['tag' => 'MODULE CODE'], function () {
        Route::get('module_codes', [ModuleCodeController::class, 'getAll'])->name('Get all MODULE CODE');
        Route::get('module_code', [ModuleCodeController::class, 'get'])->name('Get MODULE CODE');
        Route::post('module_code', [ModuleCodeController::class, 'create'])->name('create MODULE CODE');
        Route::put('module_code', [ModuleCodeController::class, 'update'])->name('update MODULE CODE');
        Route::delete('module_code', [ModuleCodeController::class, 'delete'])->name('create MODULE CODE');
    });
    Route::group(['tag' => 'TR PROGRAM TYPE'], function () {
        Route::get('tr_programs', [TrProgramTypeController::class, 'getAll'])->name('Get all TR PROGRAM TYPE');
        Route::get('tr_program', [TrProgramTypeController::class, 'get'])->name('Get TR PROGRAM TYPE');
        Route::post('tr_program', [TrProgramTypeController::class, 'create'])->name('create TR PROGRAM TYPE');
        Route::put('tr_program', [TrProgramTypeController::class, 'update'])->name('update TR PROGRAM TYPE');
        Route::delete('tr_program', [TrProgramTypeController::class, 'delete'])->name('create TR PROGRAM TYPE');
    });
    Route::group(['tag' => 'Consultant Type'], function () {
        Route::get('cons_types', [ConsultantTypeController::class, 'getAll'])->name('Get all consultant type');
        Route::get('cons_types_all', [ConsultantTypeController::class, 'getAllType'])->name('Get all consultant type');
        Route::get('cons_type', [ConsultantTypeController::class, 'get'])->name('Get Consultant Type');
        Route::post('cons_type', [ConsultantTypeController::class, 'create'])->name('create Consultant Type');
        Route::put('cons_type', [ConsultantTypeController::class, 'update'])->name('update Consultant Type');
        Route::delete('cons_type', [ConsultantTypeController::class, 'delete'])->name('create Consultant Type');
    });
    Route::group(['tag' => 'Address management'], function () {
        Route::get('setting_postalByID', [SettingPostalController::class, 'getPostalByID'])->name('Get Postal By ID');
        Route::get('setting_postal', [SettingPostalController::class, 'getAll'])->name('Get all postal');
        Route::get('setting_city', [SettingCityController::class, 'get'])->name('Get all city by id');
    });
    Route::group(['tag' => 'Consultant Qualification'], function () {
        Route::get('cons_quals', [ConsultantQualificationController::class, 'getAll'])->name('Get all consultant Qualification');
        Route::get('cons_qual', [ConsultantQualificationController::class, 'get'])->name('Get Consultant Qualification');
        Route::post('cons_qual', [ConsultantQualificationController::class, 'create'])->name('create Consultant Qualification');
        Route::put('cons_qual', [ConsultantQualificationController::class, 'update'])->name('update Consultant Qualification');
        Route::delete('cons_qual', [ConsultantQualificationController::class, 'delete'])->name('delete Consultant Qualification');
    });
    Route::group(['tag' => 'Consultant Designation Exemption'], function () {
        Route::get('cons_designs', [ConsultantDesignationExemptionController::class, 'getAll'])->name('Get all consultant Designation Exemption');
        Route::get('cons_design', [ConsultantDesignationExemptionController::class, 'get'])->name('Get Consultant Designation Exemption');
        Route::post('cons_design', [ConsultantDesignationExemptionController::class, 'create'])->name('create Consultant Designation Exemption');
        Route::put('cons_design', [ConsultantDesignationExemptionController::class, 'update'])->name('update Consultant Designation Exemption');
        Route::delete('cons_design', [ConsultantDesignationExemptionController::class, 'delete'])->name('create Consultant Designation Exemption');
    });
    Route::group(['tag' => 'Consultant Appeal'], function () {
        Route::get('cons_appeal', [ConsultantAppealController::class, 'get'])->name('Get Consultant Appeal');
        Route::post('cons_appeal', [ConsultantAppealController::class, 'create'])->name('create Consultant Appeal');
    });
    Route::group(['tag' => 'Consultant Appeal Exam'], function () {
        Route::get('cons_appeal_exam', [ConsultantAppealExaminationController::class, 'get'])->name('Get Consultant Appeal Exam');
        Route::post('cons_appeal_exam', [ConsultantAppealExaminationController::class, 'create'])->name('create Consultant Appeal Exam');
    });
    Route::group(['tag' => 'Consultant Bankruptcy Check'], function () {
        Route::get('cons_bankruptcy', [ConsultantBankruptcyController::class, 'get'])->name('Get Bankruptcy Check');
        Route::post('cons_bankruptcy', [ConsultantBankruptcyController::class, 'create'])->name('create');
    });
    Route::group(['tag' => 'Consultant PRS UNIT Familiarisation'], function () {
        Route::get('cons_prs', [ConsultantPrsFamiliarisationController::class, 'get'])->name('Get Active Ceilli');
        Route::post('cons_prs', [ConsultantPrsFamiliarisationController::class, 'create'])->name('create Active Ceilli');
    });
    Route::group(['tag' => 'Consultant PRS FOMER Familiarisation'], function () {
        Route::get('cons_prs_former', [ConsultantPrsFormerFamiliarisationController::class, 'get'])->name('Get Active Ceilli');
        Route::post('cons_prs_former', [ConsultantPrsFormerFamiliarisationController::class, 'create'])->name('create Active Ceilli');
    });
    Route::group(['tag' => 'Consultant Active Ceilli'], function () {
        Route::get('cons_ceilli', [ConsultantActiveCeilliLicenseController::class, 'get'])->name('Get PRS Familiarisation');
        Route::post('cons_ceilli', [ConsultantActiveCeilliLicenseController::class, 'create'])->name('create PRS Familiarisation');
    });
    Route::group(['tag' => 'Consultant Exam Type'], function () {
        Route::get('cons_exam_types', [ConsultantExaminationTypeController::class, 'getAll'])->name('Get all consultant  Exam Type');
        Route::get('cons_exam_type', [ConsultantExaminationTypeController::class, 'get'])->name('Get Consultant  Exam Type');
        Route::get('cons_exam_type_by_consultant_id', [ConsultantExaminationTypeController::class, 'getByConsultantId'])->name('Get Consultant  Exam Type by consultant id');
        Route::post('cons_exam_type', [ConsultantExaminationTypeController::class, 'create'])->name('create Consultant  Exam Type');
        Route::put('cons_exam_type', [ConsultantExaminationTypeController::class, 'update'])->name('update Consultant  Exam Type');
        Route::delete('cons_exam_type', [ConsultantExaminationTypeController::class, 'delete'])->name('create Consultant  Exam Type');
    });
    Route::group(['tag' => 'Consultant Exam Session'], function () {
        Route::get('cons_exam_sessions', [ConsultantExamSessionController::class, 'getAll'])->name('Get all consultant   Exam Session');
        Route::get('cons_exam_session', [ConsultantExamSessionController::class, 'get'])->name('Get Consultant   Exam Session');
        Route::post('cons_exam_session', [ConsultantExamSessionController::class, 'create'])->name('create Consultant   Exam Session');
        Route::put('cons_exam_session', [ConsultantExamSessionController::class, 'update'])->name('update Consultant   Exam Session');
        Route::delete('cons_exam_session', [ConsultantExamSessionController::class, 'delete'])->name('create Consultant   Exam Session');
    });
    Route::group(['tag' => 'Consultant Bulk UPLOAd'], function () {
        //  Route::get('cons_exam_sessions', [ConsultantExamSessionController::class, 'getAll'])->name('Get all consultant   Exam Session');
        Route::get('cons_bulk_upload', [ConsultantBulkUploadController::class, 'get'])->name('Get Consultant   BUlk Upload');
        Route::post('cons_bulk_upload_termination', [ConsultantBulkUploadController::class, 'update'])->name('Update Consultant   Bulk Upload Termination');
        // Route::put('cons_exam_session', [ConsultantExamSessionController::class, 'update'])->name('update Consultant   Exam Session');
        // Route::delete('cons_exam_session', [ConsultantExamSessionController::class, 'delete'])->name('create Consultant   Exam Session');
    });
    Route::group(['tag' => 'Consultant Type Of Application'], function () {
        Route::get('cons_type_appls', [ConsultantTypeOfApplicationController::class, 'getAll'])->name('Get all consultant   Type Of Application');
        Route::get('cons_type_appl', [ConsultantTypeOfApplicationController::class, 'get'])->name('Get Consultant   Type Of Application');
        Route::post('cons_type_appl', [ConsultantTypeOfApplicationController::class, 'create'])->name('create Consultant   Type Of Application');
        Route::put('cons_type_appl', [ConsultantTypeOfApplicationController::class, 'update'])->name('update Consultant   Type Of Application');
        Route::delete('cons_type_appl', [ConsultantTypeOfApplicationController::class, 'delete'])->name('create Consultant   Type Of Application');
    });
    Route::group(['tag' => 'Consultant Termination'], function () {
        Route::get('cons_terminates', [ConsultantTerminationTypeController::class, 'getAll'])->name('Get all consultant   Termination');
        Route::get('cons_terminate', [ConsultantTerminationTypeController::class, 'get'])->name('Get Consultant   Termination');
        Route::post('cons_terminate', [ConsultantTerminationTypeController::class, 'create'])->name('create Consultant   Termination');
        Route::put('cons_terminate', [ConsultantTerminationTypeController::class, 'update'])->name('update Consultant   Termination');
        Route::delete('cons_terminate', [ConsultantTerminationTypeController::class, 'delete'])->name('create Consultant   Termination');
    });
    Route::group(['tag' => 'Consultant Renewal Date'], function () {
        Route::get('cons_renewal', [ConsultantRenewalDateController::class, 'get'])->name('Get Consultant Renewal');
        Route::post('cons_renewal', [ConsultantRenewalDateController::class, 'create'])->name('create Consultant Renewal');
    });

    Route::group(['tag' => 'Distributor Application Approval'], function () {
        Route::get('distributor_new_application', [DistributorApprovalController::class, 'getDistributorApplicationList'])->name('Get distributor application list');
        // Route::get('distributor_review', [DistributorApprovalController::class, 'create'])->name('Update distributor application approval');
    });
    Route::get('document/{filename}', [DocumentController::class, 'getDocument']);
//Route::get('document/{filename}', [DocumentController::class, 'getDocument']);
Route::group(['tag' => 'api without middleware'], function () {
    Route::get('sidebarOE', [SideBarController::class, 'getSideBarByGroupId'])->name('Get sidebar by group Id');
    Route::post('check', [BankruptcyController::class, 'check'])->name('Bankruptcy Check');
    Route::post('bulkBankruptcyCheck', [BankruptcyController::class, 'bulkBankruptcyCheck'])->name('Bankruptcy Bulk Check');
    Route::get('check', [BankruptcyController::class, 'check'])->name('Bankruptcy Check');
    Route::get('default_country', [SettingGeneralController::class, 'getDefaultCountry'])->name('get default country');

    Route::post('send_email', [SettingEmailController::class, 'send'])->name('Send Email');
    Route::post('send_email_tac', [SettingEmailController::class, 'send_tac'])->name('Send Email');
    Route::post('send_consultant_reg_email', [SettingEmailController::class, 'send_consultant'])->name('Send Email');
    Route::post('send_cas_email', [SettingEmailController::class, 'sendCasEmail'])->name('Send Cas Email Notification');
    Route::post('send_cas_barring', [SettingEmailController::class, 'sendCasBarring'])->name('Send Cas Email Barring Notification');
    Route::post('send_acceptance_email', [SettingEmailController::class, 'sendAcceptanceEmail'])->name('Send Acceptance Email Notification');
    Route::post('send_tp_email', [SettingEmailController::class, 'sendTPEmail'])->name('Send TP Email Notification');
    Route::post('send_acceptance_email', [SettingEmailController::class, 'sendAcceptanceEmail'])->name('Send Acceptance Email Notification');
    Route::post('send_dist_reg_email', [SettingEmailController::class, 'sendDistRegEmail'])->name('Send Distributor Registration Email Notification');
    Route::post('send_dist_reg_email_return', [SettingEmailController::class, 'sendDistRegEmailReturn'])->name('Send Distributor Registration Return Email Notification');
    Route::post('send_dist_reg_email_reject', [SettingEmailController::class, 'sendDistRegEmailReject'])->name('Send Distributor Registration Reject Email Notification');
    Route::post('send_suspendRevokeCeo_Email', [SettingEmailController::class, 'sendsuspendRevokeCeoEmail'])->name('Send suspend/Revoke Ceo Email Notification');
    Route::post('send_cease_email', [SettingEmailController::class, 'sendCeaseEmail'])->name('Send Cessation Email Notification');
    Route::post('send_emailTRP', [SettingEmailController::class, 'sendTRPRegEmail'])->name('Send Training Provider Email Notification for registration');
    Route::post('send_email3rd', [SettingEmailController::class, 'send3rdRegEmail'])->name('Send 3rd party Email Notification for registration');
    Route::post('send_mediaUser_email', [SettingEmailController::class, 'sendMediaUserEmail'])->name('Send Media User Email Notification');
    Route::post('send_mediaUser_rejected', [SettingEmailController::class, 'sendMediaUserRejected'])->name('Send rejected email to media user ');
    Route::post('send_mediaUser_emailOtp', [SettingEmailController::class, 'sendMediaUserEmailOTP'])->name('Send Media User Email Notification Otp');


    Route::post('get_email_otp', [SettingEmailController::class, 'emailOtp'])->name('Request OTP number');
    Route::post('get_sms_TAC', [SmsTacController::class, 'getTAC'])->name('Get TAC');
    Route::get('verify_TAC', [SmsTacController::class, 'verifyTAC'])->name('Verify TAC');
    Route::get('setting_password', [SettingPasswordController::class, 'get'])->name('Get password characteristic');
    Route::post('setting_password', [SettingPasswordController::class, 'create'])->name('Set password characteristic');
    Route::put('setting_password', [SettingPasswordController::class, 'update'])->name('Update password characteristic');
    Route::get('approval_level_byindexNM', [ApprovalLevelController::class, 'getByIndex'])->name('Get Approval Level by index');
    Route::get('security_question_all', [SettingPasswordController::class, 'getSecurityQuestion'])->name('Get Security Question');
    Route::post('security_question_update', [SettingPasswordController::class, 'updatesecurityquestion'])->name('Update Security Question ');

    Route::get('getPageNotificationListByTypeOthers', [PageMaintenanceController::class, 'getMaintanceNotificationlistByTypeOthers'])->name('Get Notification list ');
    Route::post('get_sms_TAC_forgot', [SmsTacController::class, 'getTACFORGOT'])->name('Get TAC');
});
Route::group(['tag' => 'FMS Fund Category '], function () {
    Route::get('fund_categorys', [FmsFundcategoryController::class, 'getAll'])->name('Get all Fund Category');
    Route::get('fund_category', [FmsFundcategoryController::class, 'get'])->name('Get Fund Category');
    Route::post('fund_category', [FmsFundcategoryController::class, 'create'])->name('create Fund Category');
    Route::put('fund_category', [FmsFundcategoryController::class, 'update'])->name('update Fund Category');
    Route::delete('fund_category', [FmsFundcategoryController::class, 'delete'])->name('create Fund Category');
});
Route::group(['tag' => 'FMS Fund Type '], function () {
    Route::get('fund_types', [FmsFundtypeController::class, 'getAll'])->name('Get all Fund Type ');
    Route::get('fund_type', [FmsFundtypeController::class, 'get'])->name('Get Fund Type ');
    Route::post('fund_type', [FmsFundtypeController::class, 'create'])->name('create Fund Type ');
    Route::put('fund_type', [FmsFundtypeController::class, 'update'])->name('update Fund Type ');
    Route::delete('fund_type', [FmsFundtypeController::class, 'delete'])->name('create Fund Type ');
});
Route::group(['tag' => 'FMS Fund Group '], function () {
    Route::get('fund_groups', [FmsFundgroupController::class, 'getAll'])->name('Get all Fund  Group ');
    Route::get('fund_group', [FmsFundgroupController::class, 'get'])->name('Get Fund  Group ');
    Route::post('fund_group', [FmsFundgroupController::class, 'create'])->name('create Fund  Group ');
    Route::put('fund_group', [FmsFundgroupController::class, 'update'])->name('update Fund  Group ');
    Route::delete('fund_group', [FmsFundgroupController::class, 'delete'])->name('create Fund  Group ');
});
Route::group(['tag' => 'FMS Fund Notes '], function () {
    Route::get('fund_notes', [FmsFundnotesController::class, 'getAll'])->name('Get all Fund Notes ');
    Route::get('fund_note', [FmsFundnotesController::class, 'get'])->name('Get Fund Notes ');
    Route::post('fund_note', [FmsFundnotesController::class, 'create'])->name('create Fund Notes ');
    Route::put('fund_note', [FmsFundnotesController::class, 'update'])->name('update Fund Notes ');
    Route::delete('fund_note', [FmsFundnotesController::class, 'delete'])->name('create Fund Notes ');
});
Route::group(['tag' => 'FMS Fund Domicile '], function () {
    Route::get('fund_domiciles', [FmsFundDomicileController::class, 'getAll'])->name('Get all Fund Domicile ');
    Route::get('fund_domicile', [FmsFundDomicileController::class, 'get'])->name('Get Fund Domicile ');
    Route::post('fund_domicile', [FmsFundDomicileController::class, 'create'])->name('create Fund Domicile ');
    Route::put('fund_domicile', [FmsFundDomicileController::class, 'update'])->name('update Fund Domicile ');
    Route::delete('fund_domicile', [FmsFundDomicileController::class, 'delete'])->name('create Fund Domicile ');
});
Route::group(['tag' => 'FMS Fund Scheme Structure '], function () {
    Route::get('fund_schemes', [FmsSchemeStructureController::class, 'getAll'])->name('Get all Fund Scheme Structure ');
    Route::get('fund_scheme', [FmsSchemeStructureController::class, 'get'])->name('Get Fund Scheme Structure ');
    Route::post('fund_scheme', [FmsSchemeStructureController::class, 'create'])->name('create Fund Scheme Structure ');
    Route::put('fund_scheme', [FmsSchemeStructureController::class, 'update'])->name('update Fund Scheme Structure ');
    Route::delete('fund_scheme', [FmsSchemeStructureController::class, 'delete'])->name('create Fund Scheme Structure ');
});
Route::group(['tag' => 'FMS Fund Remark option '], function () {
    Route::get('fund_remarks', [FmsRemarkOptionController::class, 'getAll'])->name('Get all Fund Remark option ');
    Route::get('fund_remark', [FmsRemarkOptionController::class, 'get'])->name('Get Fund Remark option ');
    Route::post('fund_remark', [FmsRemarkOptionController::class, 'create'])->name('create Fund Remark option ');
    Route::put('fund_remark', [FmsRemarkOptionController::class, 'update'])->name('update Fund Remark option ');
    Route::delete('fund_remark', [FmsRemarkOptionController::class, 'delete'])->name('create Fund Remark option ');
});
Route::group(['tag' => 'FMS Fund Reason option '], function () {
    Route::get('fund_reasons', [FmsReasonOptionController::class, 'getAll'])->name('Get all Fund  Reason option ');
    Route::get('fund_reason', [FmsReasonOptionController::class, 'get'])->name('Get Fund  Reason option ');
    Route::post('fund_reason', [FmsReasonOptionController::class, 'create'])->name('create Fund  Reason option ');
    Route::put('fund_reason', [FmsReasonOptionController::class, 'update'])->name('update Fund  Reason option ');
    Route::delete('fund_reason', [FmsReasonOptionController::class, 'delete'])->name('create Fund  Reason option ');
});
Route::group(['tag' => 'Fund Cut Off time'], function () {
    Route::get('fund_cuttime', [FmsCutoffTimeController::class, 'get'])->name('Get Fund Cut Off time');
    Route::post('fund_cuttime', [FmsCutoffTimeController::class, 'create'])->name('create Fund Cut Off time ');
});
Route::group(['tag' => 'Distributor Fee'], function () {
    Route::get('dist_fee_type', [DistributorFeeController::class, 'getDistributor'])->name('Get Dist Fee');
    Route::get('dist_fees', [DistributorFeeController::class, 'getAll'])->name('Get all Dist Fee ');
    Route::post('dist_fee', [DistributorFeeController::class, 'create'])->name('create Dist Fee ');
    Route::get('dist_fee', [DistributorFeeController::class, 'get'])->name('Get Dist Fee');
    Route::put('dist_fee', [DistributorFeeController::class, 'update'])->name('update Dist Fee ');
    Route::delete('dist_fee', [DistributorFeeController::class, 'delete'])->name('create Dist Fee ');
    Route::post('dist_fee_filter', [DistributorFeeController::class, 'filter'])->name('create Dist Fee ');

    Route::get('getDistFeeByIDType', [DistributorFeeController::class, 'getDistFeeByIDType'])->name('Get all Dist Fee by id type ');
});
Route::group(['tag' => 'Waiver Fee'], function () {
    Route::get('waiver_cons_type', [WaiverFeeController::class, 'getConsType'])->name('Get Waiver Fee');
    Route::get('waiver_exam_type', [WaiverFeeController::class, 'getExamType'])->name('Get Waiver Fee');
    Route::get('waiver_type', [WaiverFeeController::class, 'getWaiverType'])->name('Get Waiver Fee');
    Route::get('waiver_fees', [WaiverFeeController::class, 'getAll'])->name('Get all Waiver Fee ');
    Route::post('waiver_fee', [WaiverFeeController::class, 'create'])->name('create Waiver Fee ');
    Route::get('waiver_fee', [WaiverFeeController::class, 'get'])->name('Get Waiver Fee');
    Route::put('waiver_fee', [WaiverFeeController::class, 'update'])->name('update Waiver Fee ');
    Route::delete('waiver_fee', [WaiverFeeController::class, 'delete'])->name('create Waiver Fee ');
    Route::get('fee_type', [WaiverFeeController::class, 'getFeeType'])->name('Get Waiver Fee');
    Route::post('waiver_fee_filter', [WaiverFeeController::class, 'filter'])->name('create Waiver Fee ');
});

Route::group(['tag' => 'Consultant Fee'], function () {
    // Route::get('cons_type_fee', [ConsultantFeeController::class, 'getAllConsType'])->name('Get Consultant Fee');
    // Route::get('cons_exam_type', [ConsultantFeeController::class, 'getAllExamType'])->name('Get Consultant Fee');
    Route::get('cons_fees', [ConsultantFeeController::class, 'getAll'])->name('Get all Consultant Fee ');
    Route::post('cons_fee', [ConsultantFeeController::class, 'create'])->name('create Consultant Fee ');
    Route::get('cons_fee', [ConsultantFeeController::class, 'get'])->name('Get Consultant Fee');
    Route::put('cons_fee', [ConsultantFeeController::class, 'update'])->name('update Consultant Fee ');
    Route::delete('cons_fee', [ConsultantFeeController::class, 'delete'])->name('create Consultant Fee ');
    Route::post('cons_fee_filter', [ConsultantFeeController::class, 'filter'])->name('create Consultant Fee ');
});
Route::group(['tag' => 'Annual Fee Invoice'], function () {
    Route::get('annual_invoices', [AnnualFeeInvoiceController::class, 'getAll'])->name('Get all Annual Fee Invoice ');
    Route::post('annual_invoice', [AnnualFeeInvoiceController::class, 'create'])->name('create Annual Fee Invoice ');
    Route::get('annual_invoice', [AnnualFeeInvoiceController::class, 'get'])->name('Get Annual Fee Invoice');
    Route::put('annual_invoice', [AnnualFeeInvoiceController::class, 'update'])->name('update Annual Fee Invoice ');
    Route::delete('annual_invoice', [AnnualFeeInvoiceController::class, 'delete'])->name('create Annual Fee Invoice ');
});
Route::group(['tag' => 'FMS Umbrella Fund'], function () {
    Route::get('umbrella_funds', [FmsUmbrellaFundController::class, 'getAll'])->name('Get all FMS Umbrella Fund ');
    Route::post('umbrella_fund', [FmsUmbrellaFundController::class, 'create'])->name('create FMS Umbrella Fund ');
    Route::get('umbrella_fund', [FmsUmbrellaFundController::class, 'get'])->name('Get FMS Umbrella Fund');
    Route::put('umbrella_fund', [FmsUmbrellaFundController::class, 'update'])->name('update FMS Umbrella Fund ');
    Route::delete('umbrella_fund', [FmsUmbrellaFundController::class, 'delete'])->name('create FMS Umbrella Fund ');
});
Route::group(['tag' => 'Login Setting'], function () {
    Route::get('login_setting', [LoginSettingController::class, 'get'])->name('Get Login');
    Route::post('login_setting', [LoginSettingController::class, 'create'])->name('create login ');
});
Route::group(['tag' => 'Login Duration'], function () {
    Route::get('login_duration', [SystemBlockDurationController::class, 'get'])->name('Get Login');
    Route::post('login_duration', [SystemBlockDurationController::class, 'create'])->name('create login ');
});
Route::group(['tag' => 'Login Session'], function () {
    Route::get('login_session', [LoginIdleSessionController::class, 'get'])->name('Get Login');
    Route::post('login_session', [LoginIdleSessionController::class, 'create'])->name('create login ');
});
Route::group(['tag' => 'Password History'], function () {
    Route::get('password_history', [PasswordHistoryController::class, 'get'])->name('Get Login');
    Route::post('password_history', [PasswordHistoryController::class, 'create'])->name('create login ');
});
Route::group(['tag' => 'Security Question'], function () {
    Route::get('security_question', [SettingPasswordController::class, 'getsecurityquestionbyid'])->name('Get Security');
    Route::post('security_question', [SettingPasswordController::class, 'createsecurityquestion'])->name('create Security Question ');
    Route::delete('security_question', [SettingPasswordController::class, 'deletesecurityquestion'])->name('Delete Security Question ');
});
Route::group(['tag' => 'Password Default'], function () {
    Route::get('password_default', [PasswordDefaultController::class, 'get'])->name('Get Password Default');
    Route::post('password_default', [PasswordDefaultController::class, 'create'])->name('create Password Default ');
});
Route::group(['tag' => 'User ID'], function () {
    Route::get('user_id', [SettingUseridController::class, 'get'])->name('Get user ID');
    Route::post('user_id', [SettingUseridController::class, 'create'])->name('create User ID ');
});

Route::group(['tag' => 'Dist Manage Group '], function () {
    Route::get('dist_manage_groups', [DistributorManageGroupController::class, 'getAll'])->name('Get all Dist Manage Group  ');
    Route::get('dist_manage_group', [DistributorManageGroupController::class, 'get'])->name('Get Dist Manage Group  ');
    Route::post('dist_manage_group', [DistributorManageGroupController::class, 'create'])->name('create Dist Manage Group  ');
    Route::put('dist_manage_group', [DistributorManageGroupController::class, 'update'])->name('update Dist Manage Group  ');
    Route::delete('dist_manage_group', [DistributorManageGroupController::class, 'delete'])->name('create Dist Manage Group  ');
});
Route::group(['tag' => 'Dist Manage Module '], function () {
    Route::get('dist_manage_modules', [DistributorManageModuleController::class, 'getAll'])->name('Get all Dist Manage Modules');
    Route::get('dist_manage_module', [DistributorManageModuleController::class, 'get'])->name('Get Dist Manage Modules');
    Route::post('dist_manage_module', [DistributorManageModuleController::class, 'create'])->name('create Dist Manage Modules');
    Route::put('dist_manage_module', [DistributorManageModuleController::class, 'update'])->name('update Dist Manage Modules');
    Route::delete('dist_manage_module', [DistributorManageModuleController::class, 'delete'])->name('create Dist Manage Modules');
});
Route::group(['tag' => 'Dist Manage SubModule '], function () {
    Route::get('dist_manage_submodules', [DistributorManageSubmoduleController::class, 'getAll'])->name('Get all Dist Manage SubModule');
    Route::get('dist_manage_submodule', [DistributorManageSubmoduleController::class, 'get'])->name('Get Dist Manage SubModule');
    Route::get('dist_get_module', [DistributorManageSubmoduleController::class, 'getModule'])->name('Get Dist Get Module');
    Route::post('dist_manage_submodule', [DistributorManageSubmoduleController::class, 'create'])->name('create Dist Manage SubModule');
    Route::put('dist_manage_submodule', [DistributorManageSubmoduleController::class, 'update'])->name('update Dist Manage SubModule');
    Route::delete('dist_manage_submodule', [DistributorManageSubmoduleController::class, 'delete'])->name('create Dist Manage SubModule');
    Route::get('dis_submodule_data', [DistributorManageSubmoduleController::class, 'distSubmoduleByModule'])->name('Get SubModule By Module');
});
Route::group(['tag' => 'Dist Manage Screen '], function () {
    Route::get('dist_manage_screens', [DistributorManageScreenController::class, 'getAll'])->name('Get all Dist Manage SubModule');
    Route::get('dist_manage_screen', [DistributorManageScreenController::class, 'get'])->name('Get Dist Manage SubModule');
    Route::get('dist_get_submodule', [DistributorManageScreenController::class, 'getSubmodule'])->name('Get Dist Get Module');
    Route::get('dist_get_processflow', [DistributorManageScreenController::class, 'getProcessFlow'])->name('Get Dist Manage SubModule');
    //Route::get('dist_manage_screen', [DistributorManageScreenController::class, 'getSubmodule'])->name('Get Dist Manage SubModule');
    Route::post('dist_manage_screen', [DistributorManageScreenController::class, 'create'])->name('create Dist Manage SubModule');
    Route::put('dist_manage_screen', [DistributorManageScreenController::class, 'update'])->name('update Dist Manage SubModule');
    Route::delete('dist_manage_screen', [DistributorManageScreenController::class, 'delete'])->name('create Dist Manage SubModule');
});
Route::group(['tag' => 'CAS letter'], function () {
    Route::get('letter_list', [CasLetterController::class, 'getAll'])->name('Get all letter list ');
    Route::post('letter_create', [CasLetterController::class, 'create'])->name('create letter template');
    Route::delete('delete_Letter', [CasLetterController::class, 'delete'])->name('create letter ');
    Route::get('edit_Letter', [CasLetterController::class, 'get'])->name('Get letter by Id');
    Route::put('update_letter', [CasLetterController::class, 'update'])->name('update letter');
});

Route::group(['tag' => 'Distributor Screen Access'], function () {
    Route::get('dist_screen_access', [DistributorScreenAccessController::class, 'get'])->name('Get screen access by Id');
    Route::get('dist_screen_access_user', [DistributorScreenAccessController::class, 'getUser'])->name('Get user');
    Route::get('dist_screen_access_auth', [DistributorScreenAccessController::class, 'getAuthLevel'])->name('Get Auth Level');
    Route::get('dist_screen_access_authpage', [DistributorScreenAccessController::class, 'getAuthorisationPage'])->name('Get Auth Level');
    Route::get('dist_screen_accesses', [DistributorScreenAccessController::class, 'getAll'])->name('Get all screen access');
    Route::post('dist_screen_access', [DistributorScreenAccessController::class, 'create'])->name('Create screen access');
    Route::put('dist_screen_access', [DistributorScreenAccessController::class, 'update'])->name('update Dist Manage screen Access');
    Route::delete('dist_screen_access', [DistributorScreenAccessController::class, 'delete'])->name('Delete Dist');
});
Route::group(['tag' => 'Cons Manage Group '], function () {
    Route::get('cons_manage_groups', [ConsultantManageGroupController::class, 'getAll'])->name('Get all cons Manage Group  ');
    Route::get('cons_manage_group', [ConsultantManageGroupController::class, 'get'])->name('Get cons Manage Group  ');
    Route::post('cons_manage_group', [ConsultantManageGroupController::class, 'create'])->name('create cons Manage Group  ');
    Route::put('cons_manage_group', [ConsultantManageGroupController::class, 'update'])->name('update cons Manage Group  ');
    Route::delete('cons_manage_group', [ConsultantManageGroupController::class, 'delete'])->name('create cons Manage Group  ');
});
Route::group(['tag' => 'Cons Manage Module '], function () {
    Route::get('cons_manage_modules', [ConsultantManageModuleController::class, 'getAll'])->name('Get all cons Manage Modules');
    Route::get('cons_manage_module', [ConsultantManageModuleController::class, 'get'])->name('Get cons Manage Modules');
    Route::post('cons_manage_module', [ConsultantManageModuleController::class, 'create'])->name('create cons Manage Modules');
    Route::put('cons_manage_module', [ConsultantManageModuleController::class, 'update'])->name('update cons Manage Modules');
    Route::delete('cons_manage_module', [ConsultantManageModuleController::class, 'delete'])->name('create cons Manage Modules');
});
Route::group(['tag' => 'Cons Manage SubModule '], function () {
    Route::get('cons_manage_submodules', [ConsultantManageSubmoduleController::class, 'getAll'])->name('Get all cons Manage SubModule');
    Route::get('cons_manage_submodule', [ConsultantManageSubmoduleController::class, 'get'])->name('Get cons Manage SubModule');
    Route::get('cons_get_module', [ConsultantManageSubmoduleController::class, 'getConsModule'])->name('Get cons Get Module');
    Route::post('cons_manage_submodule', [ConsultantManageSubmoduleController::class, 'create'])->name('create cons Manage SubModule');
    Route::put('cons_manage_submodule', [ConsultantManageSubmoduleController::class, 'update'])->name('update cons Manage SubModule');
    Route::delete('cons_manage_submodule', [ConsultantManageSubmoduleController::class, 'delete'])->name('create cons Manage SubModule');
    Route::get('cons_manage_submodules_by_module', [ConsultantManageSubmoduleController::class, 'getSubmoduleByModule'])->name('Get SubModule by Module');
});
Route::group(['tag' => 'cons Manage Screen '], function () {
    Route::get('cons_manage_screens', [ConsultantManageScreenController::class, 'getAll'])->name('Get all cons Manage SubModule');
    Route::get('cons_manage_screen', [ConsultantManageScreenController::class, 'get'])->name('Get cons Manage SubModule');
    //Route::get('cons_get_module', [ConsultantManageScreenController::class, 'getScreen'])->name('Get cons Get Module');
    Route::get('cons_get_processflow', [ConsultantManageScreenController::class, 'getProcessFlow'])->name('Get cons Manage SubModule');
    Route::get('cons_get_submodule', [ConsultantManageScreenController::class, 'getSubmodule'])->name('Get cons Manage SubModule');
    Route::post('cons_manage_screen', [ConsultantManageScreenController::class, 'create'])->name('create cons Manage SubModule');
    Route::put('cons_manage_screen', [ConsultantManageScreenController::class, 'update'])->name('update cons Manage SubModule');
    Route::delete('cons_manage_screen', [ConsultantManageScreenController::class, 'delete'])->name('create cons Manage SubModule');
    Route::get('cons_manage_screens_by_module', [ConsultantManageScreenController::class, 'getByModule'])->name('Get Screen By Module');
});
Route::group(['tag' => 'Cons Screen Access'], function () {
    Route::get('cons_screen_access', [ConsultantScreenAccessController::class, 'get'])->name('Get screen access by Id');
    Route::get('cons_screen_access_user', [ConsultantScreenAccessController::class, 'getUser'])->name('Get user');
    Route::get('cons_screen_access_auth', [ConsultantScreenAccessController::class, 'getAuthLevel'])->name('Get Auth Level');
    Route::get('cons_screen_access_authpage', [ConsultantScreenAccessController::class, 'getAuthorisationPage'])->name('Get Auth Level');
    Route::get('cons_screen_accesses', [ConsultantScreenAccessController::class, 'getAll'])->name('Get all screen access');
    Route::post('cons_screen_access', [ConsultantScreenAccessController::class, 'create'])->name('Create screen access');
    Route::put('cons_screen_access', [ConsultantScreenAccessController::class, 'update'])->name('update Dist Manage screen Access');
    Route::delete('cons_screen_access', [ConsultantScreenAccessController::class, 'delete'])->name('create third Manage Group  ');
});
Route::group(['tag' => 'Third Party Manage Group '], function () {
    Route::get('third_manage_groups', [ThirdpartyManageGroupController::class, 'getAll'])->name('Get all third Manage Group  ');
    Route::get('third_manage_group', [ThirdpartyManageGroupController::class, 'get'])->name('Get third Manage Group  ');
    Route::post('third_manage_group', [ThirdpartyManageGroupController::class, 'create'])->name('create third Manage Group  ');
    Route::put('third_manage_group', [ThirdpartyManageGroupController::class, 'update'])->name('update third Manage Group  ');
    Route::delete('third_manage_group', [ThirdpartyManageGroupController::class, 'delete'])->name('create third Manage Group  ');
});
Route::group(['tag' => 'third Manage Module '], function () {
    Route::get('third_manage_modules', [ThirdpartyManageModuleController::class, 'getAll'])->name('Get all third Manage Modules');
    Route::get('third_manage_module', [ThirdpartyManageModuleController::class, 'get'])->name('Get third Manage Modules');
    Route::post('third_manage_module', [ThirdpartyManageModuleController::class, 'create'])->name('create third Manage Modules');
    Route::put('third_manage_module', [ThirdpartyManageModuleController::class, 'update'])->name('update third Manage Modules');
    Route::delete('third_manage_module', [ThirdpartyManageModuleController::class, 'delete'])->name('create third Manage Modules');
});
Route::group(['tag' => 'Third Party Manage SubModule '], function () {
    Route::get('third_manage_submodules', [ThirdpartyManageSubmoduleController::class, 'getAll'])->name('Get all third Manage SubModule');
    Route::get('third_manage_submodule', [ThirdpartyManageSubmoduleController::class, 'get'])->name('Get third Manage SubModule');
    Route::get('third_get_module', [ThirdpartyManageSubmoduleController::class, 'getThirdModule'])->name('Get third Get Module');
    Route::post('third_manage_submodule', [ThirdpartyManageSubmoduleController::class, 'create'])->name('create third Manage SubModule');
    Route::put('third_manage_submodule', [ThirdpartyManageSubmoduleController::class, 'update'])->name('update third Manage SubModule');
    Route::delete('third_manage_submodule', [ThirdpartyManageSubmoduleController::class, 'delete'])->name('create third Manage SubModule');
    Route::get('third_manage_submodules_by_Module', [ThirdpartyManageSubmoduleController::class, 'getByModule'])->name('Get by Module');
});
Route::group(['tag' => 'Third Party Manage Screen '], function () {
    Route::get('third_manage_screens', [ThirdPartyManageScreenController::class, 'getAll'])->name('Get all third Manage SubModule');
    Route::get('third_manage_screen', [ThirdPartyManageScreenController::class, 'get'])->name('Get third Manage SubModule');
    //Route::get('third_get_module', [ThirdPartyManageScreenController::class, 'getScreen'])->name('Get third Get Module');
    Route::get('third_get_processflow', [ThirdPartyManageScreenController::class, 'getProcessFlow'])->name('Get third Manage SubModule');
    Route::get('third_get_submodule', [ThirdPartyManageScreenController::class, 'getSubmodule'])->name('Get third Manage SubModule');
    Route::post('third_manage_screen', [ThirdPartyManageScreenController::class, 'create'])->name('create third Manage SubModule');
    Route::put('third_manage_screen', [ThirdPartyManageScreenController::class, 'update'])->name('update third Manage SubModule');
    Route::delete('third_manage_screen', [ThirdPartyManageScreenController::class, 'delete'])->name('create third Manage SubModule');
    Route::get('third_manage_screen_by_Module', [ThirdPartyManageScreenController::class, 'getScreenByModule'])->name('Get all third Manage SubModule');
});
Route::group(['tag' => 'Third Party Screen Access'], function () {
    Route::get('third_screen_access', [ThirdpartyScreenAccessController::class, 'get'])->name('Get screen access by Id');
    Route::get('third_screen_access_user', [ThirdpartyScreenAccessController::class, 'getUser'])->name('Get user');
    Route::get('third_screen_access_auth', [ThirdpartyScreenAccessController::class, 'getAuthLevel'])->name('Get Auth Level');
    Route::get('third_screen_access_authpage', [ThirdpartyScreenAccessController::class, 'getAuthorisationPage'])->name('Get Auth Level');
    Route::get('third_screen_accesses', [ThirdpartyScreenAccessController::class, 'getAll'])->name('Get all screen access');
    Route::post('third_screen_access', [ThirdpartyScreenAccessController::class, 'create'])->name('Create screen access');
    Route::put('third_screen_access', [ThirdpartyScreenAccessController::class, 'update'])->name('update Dist Manage screen Access');
    Route::delete('third_screen_access', [ThirdpartyScreenAccessController::class, 'delete'])->name('create third Manage Group  ');
});
Route::group(['tag' => 'Training Provider Manage Group '], function () {
    Route::get('tp_manage_groups', [TpManageGroupController::class, 'getAll'])->name('Get all tp Manage Group  ');
    Route::get('tp_manage_group', [TpManageGroupController::class, 'get'])->name('Get tp Manage Group  ');
    Route::post('tp_manage_group', [TpManageGroupController::class, 'create'])->name('create tp Manage Group  ');
    Route::put('tp_manage_group', [TpManageGroupController::class, 'update'])->name('update tp Manage Group  ');
    Route::delete('tp_manage_group', [TpManageGroupController::class, 'delete'])->name('create tp Manage Group  ');
});
Route::group(['tag' => 'Training Provider Manage Module '], function () {
    Route::get('tp_manage_modules', [TpManageModuleController::class, 'getAll'])->name('Get all tp Manage Modules');
    Route::get('tp_manage_module', [TpManageModuleController::class, 'get'])->name('Get tp Manage Modules');
    Route::post('tp_manage_module', [TpManageModuleController::class, 'create'])->name('create tp Manage Modules');
    Route::put('tp_manage_module', [TpManageModuleController::class, 'update'])->name('update tp Manage Modules');
    Route::delete('tp_manage_module', [TpManageModuleController::class, 'delete'])->name('create tp Manage Modules');
});
Route::group(['tag' => 'Training Provider Manage SubModule '], function () {
    Route::get('tp_manage_submodules', [TpManageSubmoduleController::class, 'getAll'])->name('Get all tp Manage SubModule');
    Route::get('tp_manage_submodule', [TpManageSubmoduleController::class, 'get'])->name('Get tp Manage SubModule');
    Route::get('tp_get_module', [TpManageSubmoduleController::class, 'getThirdModule'])->name('Get tp Get Module');
    Route::post('tp_manage_submodule', [TpManageSubmoduleController::class, 'create'])->name('create tp Manage SubModule');
    Route::put('tp_manage_submodule', [TpManageSubmoduleController::class, 'update'])->name('update tp Manage SubModule');
    Route::delete('tp_manage_submodule', [TpManageSubmoduleController::class, 'delete'])->name('create tp Manage SubModule');
    Route::get('tp_manage_submodules_by_module', [TpManageSubmoduleController::class, 'getByModule'])->name('Get by module');
});
Route::group(['tag' => 'Training Provider Manage Screen '], function () {
    Route::get('tp_manage_screens', [TpManageScreenController::class, 'getAll'])->name('Get all tp Manage SubModule');
    Route::get('tp_manage_screen', [TpManageScreenController::class, 'get'])->name('Get tp Manage SubModule');
    // Route::get('tp_get_module', [TpManageScreenController::class, 'getScreen'])->name('Get tp Get Module');
    Route::get('tp_get_processflow', [TpManageScreenController::class, 'getProcessFlow'])->name('Get tp Manage SubModule');
    Route::get('tp_get_submodule', [TpManageScreenController::class, 'getSubmodule'])->name('Get tp Manage SubModule');
    Route::post('tp_manage_screen', [TpManageScreenController::class, 'create'])->name('create tp Manage SubModule');
    Route::put('tp_manage_screen', [TpManageScreenController::class, 'update'])->name('update tp Manage SubModule');
    Route::delete('tp_manage_screen', [TpManageScreenController::class, 'delete'])->name('create tp Manage SubModule');
    Route::get('tp_manage_screens_by_module', [TpManageScreenController::class, 'getByModule'])->name('Get by module');
});
Route::group(['tag' => 'Training Provider Screen Access'], function () {
    Route::get('tp_screen_access', [TpScreenAccessController::class, 'get'])->name('Get screen access by Id');
    Route::get('tp_screen_access_user', [TpScreenAccessController::class, 'getUser'])->name('Get user');
    Route::get('tp_screen_access_auth', [TpScreenAccessController::class, 'getAuthLevel'])->name('Get Auth Level');
    Route::get('tp_screen_access_authpage', [TpScreenAccessController::class, 'getAuthorisationPage'])->name('Get Auth Level');
    Route::get('tp_screen_accesses', [TpScreenAccessController::class, 'getAll'])->name('Get all screen access');
    Route::post('tp_screen_access', [TpScreenAccessController::class, 'create'])->name('Create screen access');
    Route::put('tp_screen_access', [TpScreenAccessController::class, 'update'])->name('update Dist Manage screen Access');
    Route::delete('tp_screen_access', [TpScreenAccessController::class, 'delete'])->name('Delete tp');
});

Route::group(['tag' => 'Purge Data Setting'], function () {
    Route::get('get_purge_data', [PurgeDataController::class, 'get'])->name('Get Purge Data');
    Route::post('save_purge_data', [PurgeDataController::class, 'create'])->name('Save Purge Data');
});
Route::group(['tag' => 'Data retention Setting'], function () {
    Route::get('get_data_retention', [DataRetentionController::class, 'get'])->name('Get Purge Data');
    Route::post('save_data_retention', [DataRetentionController::class, 'create'])->name('Save Purge Data');
    Route::post('archive_data_retention', [DataRetentionController::class, 'archive'])->name('archive Purge Data');
});

Route::group(['tag' => 'User Management Setting'], function () {
    Route::get('get_all_city', [UserManageController::class, 'getAllCity'])->name('Get All City');
    Route::get('get_all_postcode', [UserManageController::class, 'getAllPostcode'])->name('Get All post');
    Route::post('submit_user_role', [UserManageController::class, 'submitUserRole'])->name('Save Purge Data');
    Route::post('get_user_manage_data', [UserManageController::class, 'getUserManageData'])->name('Get User Data');
    Route::get('get_user_info', [UserManageController::class, 'getUserInfo'])->name('Get User Data');
    Route::get('get_user_by_id', [UserManageController::class, 'getUserInfoById'])->name('Get User Data');
    Route::post('save_user_approve', [UserManageController::class, 'saveUserApprove'])->name('Save User Approval');
});


Route::group(['tag' => 'Distributor Approval Level'], function () {
    Route::get('dist_approval_level_byindex', [DistributorApprovalLevelController::class, 'getDistByIndex'])->name('Get DIstributor Approval Level by index');
});
Route::group(['tag' => 'Page Maintenance'], function () {
    Route::get('page_list', [PageMaintenanceController::class, 'getAll'])->name('Get all letter list ');
    Route::post('page_create', [PageMaintenanceController::class, 'create'])->name('create letter template');
    Route::delete('delete_page', [PageMaintenanceController::class, 'delete'])->name('create letter ');
    Route::get('edit_page', [PageMaintenanceController::class, 'get'])->name('Get letter by Id');
    Route::put('update_page', [PageMaintenanceController::class, 'update'])->name('update page maintanance');
    Route::get('get_audience', [PageMaintenanceController::class, 'getAudience'])->name('Get Audience');
    Route::post('search_page_list', [PageMaintenanceController::class, 'filter'])->name('Get all letter list ');
    Route::get('getMaintanceNotificationlist', [PageMaintenanceController::class, 'getMaintanceNotificationlist'])->name('Get Notification list ');
    Route::get('getPageNotificationListByType', [PageMaintenanceController::class, 'getMaintanceNotificationlistByType'])->name('Get Notification list ');
    Route::get('detail_page', [PageMaintenanceController::class, 'getdetail'])->name('Get letter by Id');
});

Route::group(['tag' => 'User Active Inactive'], function () {
    Route::get('active_inactive_user', [UserActiveInactiveController::class, 'get'])->name('Get user Active List');
    Route::post('UserAI_create', [UserActiveInactiveController::class, 'create'])->name('Create');
    Route::put('UserAI_update', [UserActiveInactiveController::class, 'update'])->name('update');
    Route::delete('delete_user_AI', [UserActiveInactiveController::class, 'delete'])->name('Delete');
});

Route::group(['tag' => 'Color Template Setting'], function () {
    Route::post('create_color_code', [ColourTemplateSettingController::class, 'create'])->name('Create Colour Code');
    Route::get('all_color_code', [ColourTemplateSettingController::class, 'getAll'])->name('Get all Colour Code');
    Route::get('all_color_code_active', [ColourTemplateSettingController::class, 'getAllActiveColor'])->name('Get all Colour Code');
    Route::get('color_code_active', [ColourTemplateSettingController::class, 'getActiveColor'])->name('Get all Colour Code');
    Route::get('color_by_id', [ColourTemplateSettingController::class, 'get'])->name('Get Colour Code by Id');
    Route::put('color_update', [ColourTemplateSettingController::class, 'update'])->name('Update  Colour Code');
    Route::delete('color_delete', [ColourTemplateSettingController::class, 'delete'])->name('Delete Colour Code');
    Route::get('color_set_default', [ColourTemplateSettingController::class, 'setDefaultColour'])->name('Delete Colour Code');
});
Route::group(['tag' => 'Dashboard Setting'], function () {
    Route::get('dashboard_setting_distributor', [DashboardMainSettingController::class, 'getDistributorDashboardSetting'])->name('Get Distributor Setting');
    Route::get('dashboard_chart_list', [DashboardChartTypeController::class, 'get'])->name('Get Chart List Setting');
    Route::get('all_distributor_dashboard_list', [DashboardMainSettingController::class, 'getAllDistributor'])->name('Get Dashboard List Setting');
    Route::post('create_dashboard_setting', [DashboardMainSettingController::class, 'create'])->name('Create Dashboard List Setting');
    Route::get('dashboard_setting_by_id', [DashboardMainSettingController::class, 'getById'])->name('Get Dashboard List Setting');
    Route::put('dashboard_update', [DashboardMainSettingController::class, 'update'])->name('Update Dashboard List Setting');
    Route::delete('dashboard_setting_delete', [DashboardMainSettingController::class, 'delete'])->name('Delete Dashboard List Setting');

    Route::get('dashboard_setting_cpd', [DashboardMainSettingController::class, 'getcpdDashboardSetting'])->name('Get CPD Setting');
});
Route::group(['tag' => 'CPD Dashboard Setting'], function () {
    Route::post('cpd_dashboard_setting_create', [DashboardCpdDisplaySettingController::class, 'create'])->name('CPD Setting Create');
    Route::post('delete_cpd_dashboard_setting', [DashboardCpdDisplaySettingController::class, 'delete'])->name('CPD Setting Delete');
    Route::get('get_cpd_dashboard_setting', [DashboardCpdDisplaySettingController::class, 'get'])->name('Get CPD Setting');
    Route::get('get_cpd_chart_setting', [DashboardCpdDisplaySettingController::class, 'getChartSetting'])->name('Get CPD Chart Setting');
    Route::get('get_cpd_chart_setting_two', [DashboardCpdDisplaySettingController::class, 'getChartSettingTwo'])->name('Get CPD Chart Setting Two');
    Route::get('get_cpd_chart_setting_three', [DashboardCpdDisplaySettingController::class, 'getChartSettingThree'])->name('Get CPD Chart Setting Three');
    Route::get('get_cpd_chart_setting_four', [DashboardCpdDisplaySettingController::class, 'getChartSettingFour'])->name('Get CPD Chart Setting Four');
    Route::get('get_cpd_chart_setting_five', [DashboardCpdDisplaySettingController::class, 'getChartSettingFive'])->name('Get CPD Chart Setting Five');
    Route::get('get_cpd_chart_setting_six', [DashboardCpdDisplaySettingController::class, 'getChartSettingSix'])->name('Get CPD Chart Setting Six');
    Route::get('get_cpd_chart_setting_seven', [DashboardCpdDisplaySettingController::class, 'getChartSettingSeven'])->name('Get CPD Chart Setting Seven');
    Route::get('get_cpd_chart_setting_eight', [DashboardCpdDisplaySettingController::class, 'getChartSettingEight'])->name('Get CPD Chart Setting Eight');
});


Route::group(['tag' => 'CPD REVOCATION'], function () {
    Route::post('cpd_revocation_day', [CpdRevocationApprovalDaysController::class, 'create'])->name('Create  Revocation');
    Route::get('cpd_revocation_day_get', [CpdRevocationApprovalDaysController::class, 'get'])->name('Get Revocation');
});
Route::group(['tag' => 'CAS Dashboard Setting'], function () {
    Route::get('dashboard_setting_cas', [DashboardMainSettingController::class, 'getcasDashboardSetting'])->name('CAS Setting LIST');
    Route::post('cas_dashboard_setting_create', [DashboardCasDisplaySettingController::class, 'create'])->name('CAS Setting Create');
    Route::post('delete_cas_dashboard_setting', [DashboardCasDisplaySettingController::class, 'delete'])->name('CAS Setting Delete');
    Route::get('get_cas_dashboard_setting', [DashboardCasDisplaySettingController::class, 'get'])->name('Get CAS Setting');
    Route::get('get_cas_chart_setting', [DashboardCasDisplaySettingController::class, 'getChartSetting'])->name('Get CAS Chart Setting');
    Route::get('get_cas_chart_setting_two', [DashboardCasDisplaySettingController::class, 'getChartSettingTwo'])->name('Get CAS Chart Setting Two');
    Route::get('get_cas_chart_setting_three', [DashboardCasDisplaySettingController::class, 'getChartSettingThree'])->name('Get CAS Chart Setting Three');
    Route::get('get_cas_chart_setting_four', [DashboardCasDisplaySettingController::class, 'getChartSettingFour'])->name('Get CAS Chart Setting Four');
});
Route::group(['tag' => 'FMS Dashboard Setting'], function () {
    Route::get('dashboard_setting_fms', [DashboardMainSettingController::class, 'getFmsDashboardSetting'])->name('FMS Setting LIST');
    Route::post('fms_dashboard_setting_create', [DashboardFmsDisplaySettingController::class, 'create'])->name('FMS Setting Create');
    Route::post('delete_fms_dashboard_setting', [DashboardFmsDisplaySettingController::class, 'delete'])->name('FMS Setting Delete');
    Route::get('get_fms_dashboard_setting', [DashboardFmsDisplaySettingController::class, 'get'])->name('Get FMS Setting');
    Route::get('get_fms_rd_chart_setting', [DashboardFmsDisplaySettingController::class, 'getFmsRdChartSetting'])->name('Get FMS RD Chart Setting');
    Route::get('get_fms_rd_chart_setting_two', [DashboardFmsDisplaySettingController::class, 'getFmsRdChartSettingTwo'])->name('Get FMS Chart Setting Two');
    Route::get('get_fms_id_chart_setting', [DashboardFmsDisplaySettingController::class, 'getFmsIDChartSettingOne'])->name('Get FMS ID Chart Setting ONE');
    Route::get('get_fms_id_chart_setting_two', [DashboardFmsDisplaySettingController::class, 'getFmsIDChartSettingTwo'])->name('Get FMS ID Chart Setting Two');
    Route::get('get_fms_id_chart_setting_three', [DashboardFmsDisplaySettingController::class, 'getFmsIDChartSettingThree'])->name('Get FMS ID Chart Setting Three');
    Route::get('get_fms_id_chart_setting_four', [DashboardFmsDisplaySettingController::class, 'getFmsIDChartSettingFour'])->name('Get FMS ID Chart Setting Four');
    Route::get('get_fms_id_chart_setting_five', [DashboardFmsDisplaySettingController::class, 'getFmsIDChartSettingFive'])->name('Get FMS ID Chart Setting Five');
    Route::get('get_fms_id_chart_setting_six', [DashboardFmsDisplaySettingController::class, 'getFmsIDChartSettingSix'])->name('Get FMS ID Chart Setting Six');
});

Route::group(['tag' => 'ADMIN Dashboard Setting'], function () {
    Route::get('dashboard_setting_admin', [DashboardMainSettingController::class, 'getAdminDashboardSetting'])->name('ADMIN Setting LIST');
    Route::post('admin_dashboard_setting_create', [DashboardAdminDisplaySettingController::class, 'create'])->name('ADMIN Setting Create');
    Route::post('delete_admin_dashboard_setting', [DashboardAdminDisplaySettingController::class, 'delete'])->name('ADMIN Setting Delete');
    Route::get('get_admin_dashboard_setting', [DashboardAdminDisplaySettingController::class, 'get'])->name('Get ADMIN Setting');
    Route::get('get_admin_chart_setting_one', [DashboardAdminDisplaySettingController::class, 'getAdminChartSettingOne'])->name('Get ADMIN Chart Setting');
    Route::get('get_admin_chart_setting_two', [DashboardAdminDisplaySettingController::class, 'getAdminChartSettingTwo'])->name('Get ADMIN Chart Setting Two');
    // Route::get('get_cas_chart_setting_three', [DashboardCasDisplaySettingController::class, 'getChartSettingThree'])->name('Get CAS Chart Setting Three');
    Route::get('get_admin_chart_setting_four', [DashboardAdminDisplaySettingController::class, 'getAdminChartSettingFour'])->name('Get ADMIN Chart Setting Four');
    Route::get('get_admin_chart_setting_five', [DashboardAdminDisplaySettingController::class, 'getAdminChartSettingFive'])->name('Get ADMIN Chart Setting Four');
});
Route::group(['tag' => 'ADMIN System Information'], function () {
    Route::get('system_information_admin', [SystemInformationAdminController::class, 'get'])->name('Get ADMIN SYSTEM INFORMATION');
    Route::post('create_system_information', [SystemInformationAdminController::class, 'create'])->name('ADMIN SYSTEM INFORMATION Create');
    Route::get('system_information_by_id', [SystemInformationAdminController::class, 'getById'])->name('Get ADMIN SYSTEM INFORMATION');
    Route::put('system_information_update', [SystemInformationAdminController::class, 'update'])->name('ADMIN SYSTEM INFORMATION Update');
    Route::delete('system_information_delete', [SystemInformationAdminController::class, 'delete'])->name('ADMIN SYSTEM INFORMATION DELETE');
});

Route::group(['tag' => 'Consultant Dashboard Setting'], function () {
    Route::get('dashboard_setting_consultant', [DashboardMainSettingController::class, 'getConsultantDashboardSetting'])->name('CONSULTANT Setting LIST');
    Route::post('consultant_dashboard_setting_create', [DashboardConsultantDisplaySettingController::class, 'create'])->name('CONSULTANT Setting Create');
    Route::post('delete_consultant_dashboard_setting', [DashboardConsultantDisplaySettingController::class, 'delete'])->name('CONSULTANT Setting Delete');
    Route::get('get_consultant_dashboard_setting', [DashboardConsultantDisplaySettingController::class, 'get'])->name('Get CONSULTANT Setting');
    Route::get('get_consultant_chart_setting_one', [DashboardConsultantDisplaySettingController::class, 'getChartSettingOne'])->name('Get CONSULTANT Chart Setting One');
    Route::get('get_consultant_chart_setting_four', [DashboardConsultantDisplaySettingController::class, 'getChartSettingFour'])->name('Get CONSULTANT Chart Setting Four');
    Route::get('get_consultant_chart_setting_five', [DashboardConsultantDisplaySettingController::class, 'getChartSettingFive'])->name('Get CONSULTANT Chart Setting Five');
});
Route::group(['tag' => 'Finance Dashboard Setting'], function () {
    Route::get('dashboard_setting_finance', [DashboardMainSettingController::class, 'getFinanceDashboardSetting'])->name('Finance Setting LIST');
    Route::post('finance_dashboard_setting_create', [DashboardFinanceDisplaySettingController::class, 'create'])->name('Finance Setting Create');
    Route::post('delete_finance_dashboard_setting', [DashboardFinanceDisplaySettingController::class, 'delete'])->name('Finance Setting Delete');
    Route::get('get_finance_dashboard_setting', [DashboardFinanceDisplaySettingController::class, 'get'])->name('Get FINANCE Setting');
    Route::get('get_finance_chart_setting_one', [DashboardFinanceDisplaySettingController::class, 'getChartSettingOne'])->name('Get FINANCE Chart Setting One');
    Route::get('get_finance_chart_setting_two', [DashboardFinanceDisplaySettingController::class, 'getChartSettingTwo'])->name('Get FINANCE Chart Setting Two');
    Route::get('get_finance_chart_setting_seven', [DashboardFinanceDisplaySettingController::class, 'getChartSettingSeven'])->name('Get FINANCE Chart Setting Seven');
});
Route::group(['tag' => 'Annual Fee Dashboard Setting'], function () {
    Route::get('dashboard_setting_annual', [DashboardMainSettingController::class, 'getAnnualDashboardSetting'])->name('Annual Setting LIST');
    Route::post('annual_dashboard_setting_create', [DashboardAnnualDisplaySettingController::class, 'create'])->name('Annual Setting Create');
    Route::post('delete_annual_dashboard_setting', [DashboardAnnualDisplaySettingController::class, 'delete'])->name('Annual Setting Delete');
    Route::get('get_annualfee_dashboard_setting', [DashboardAnnualDisplaySettingController::class, 'get'])->name('Get Annual Fee  Setting');
    Route::get('get_annual_chart_setting_one', [DashboardAnnualDisplaySettingController::class, 'getAnnualChartOne'])->name('Get Annual Fee  Chart One');
    Route::get('get_annual_chart_setting_two', [DashboardAnnualDisplaySettingController::class, 'getAnnualChartTwo'])->name('Get Annual Fee  Chart Two');
    Route::get('get_annual_chart_setting_three', [DashboardAnnualDisplaySettingController::class, 'getAnnualChartThree'])->name('Get Annual Fee  Chart Three');
    Route::get('get_annual_chart_setting_four', [DashboardAnnualDisplaySettingController::class, 'getAnnualChartFour'])->name('Get Annual Fee  Chart Four');
    Route::get('get_annual_chart_setting_five', [DashboardAnnualDisplaySettingController::class, 'getAnnualChartFive'])->name('Get Annual Fee  Chart Five');
    Route::get('get_annual_chart_setting_six', [DashboardAnnualDisplaySettingController::class, 'getAnnualChartSix'])->name('Get Annual Fee  Chart Six');
    Route::get('get_annual_chart_setting_seven', [DashboardAnnualDisplaySettingController::class, 'getAnnualChartSeven'])->name('Get Annual Fee  Chart Seven');
    Route::get('get_annual_chart_setting_eight', [DashboardAnnualDisplaySettingController::class, 'getAnnualChartEight'])->name('Get Annual Fee  Chart Eight');
    Route::get('get_annual_chart_setting_nine', [DashboardAnnualDisplaySettingController::class, 'getAnnualChartNine'])->name('Get Annual Fee  Chart Nine');
    Route::get('get_annual_chart_setting_ten', [DashboardAnnualDisplaySettingController::class, 'getAnnualChartTen'])->name('Get Annual Fee  Chart Ten');
});
Route::group(['tag' => 'Consultant Alert Report'], function () {
    // Route::get('cas_utc_tagging_list_report', [DashboardChartTypeController::class, 'getCasUtcTaggingListReport'])->name('Annual Setting LIST');
    Route::any('casutcreport', [DashboardChartTypeController::class, 'getCasUtcTaggingListReport'])->name('CAS UTC REPORT');
    Route::any('casutcreportpdf', [DashboardChartTypeController::class, 'getCasUtcTaggingListPdfReport'])->name('CAS UTC PORTRAIT PDF');
    Route::any('casutcreportlandscapepdf', [DashboardChartTypeController::class, 'getCasUtcTaggingListPdfReportLandscape'])->name('CAS UTC LANDSCAPE PDF');
    Route::any('casutcexcel', [DashboardChartTypeController::class, 'getCasUtcExcel'])->name('CAS UTC EXCEL');
    Route::any('casenquiryreport', [DashboardChartTypeController::class, 'getCasEnquiryReport'])->name('CAS ENQUIRY REPORT');
    Route::any('casenquiryreportpdf', [DashboardChartTypeController::class, 'getCasEnquiryPortraitPdf'])->name('CAS ENQUIRY  PORTRAIT PDF');
    Route::any('casenquiryreportlandscapepdf', [DashboardChartTypeController::class, 'getCasEnquiryLandscapePdf'])->name('CAS ENQUIRY LANDSCAPE PDF');
    Route::any('casenquiryexcel', [DashboardChartTypeController::class, 'getCasEnquiryExcel'])->name('CAS ENQUIRY EXCEL');
    Route::any('casenquiryfiledownload', [DashboardChartTypeController::class, 'getCasFileDownload'])->name('GET Cas Enquiry Excel');
    Route::any('cascomplainbyfimm', [DashboardChartTypeController::class, 'getComplainByFimm'])->name('CAS COMPLAIN BY FIMM');
    Route::any('cascomplainportraitpdf', [DashboardChartTypeController::class, 'getCasComplainPortraitPdf'])->name('CAS COMPLAIN  PORTRAIT PDF');
    Route::any('cascomplainlandscapepdf', [DashboardChartTypeController::class, 'getCasComplainLandscapePdf'])->name('CAS COMPLAIN LANDSCAPE PDF');
    Route::any('cascomplainfimmexcel', [DashboardChartTypeController::class, 'getCasComplainFimmExcel'])->name('CAS Complain Fimm EXCEL');
    Route::any('cassanctionedreport', [DashboardChartTypeController::class, 'getSanctionedByFimm'])->name('CAS Sanction BY FIMM');
    Route::any('cassanctionedreportpdf', [DashboardChartTypeController::class, 'getCasSanctionedPortraitPdf'])->name('CAS COMPLAIN  PORTRAIT PDF');
    Route::any('cassanctionedreportlandscapepdf', [DashboardChartTypeController::class, 'getCasSanctionedLandscapePdf'])->name('CAS COMPLAIN LANDSCAPE PDF');
    Route::any('cassanctionedexcel', [DashboardChartTypeController::class, 'getCasSanctionedReportExcel'])->name('CAS Sanctioned EXCEL');
});
Route::group(['tag' => 'Distributor Dashboard Setting'], function () {
    Route::post('distributor_dashboard_setting', [DashboardDistributorDisplaySettingController::class, 'create'])->name('Distributor Dashboard Setting');
    Route::get('get_distributor_dashboard_setting', [DashboardDistributorDisplaySettingController::class, 'get'])->name('Distributor Dashboard Setting Get');
    Route::post('delete_distributor_dashboard_setting', [DashboardDistributorDisplaySettingController::class, 'delete'])->name('Distributor Dashboard Setting Delete');
    Route::get('get_distributor_chart_setting_three', [DashboardDistributorDisplaySettingController::class, 'getChartSettingThree'])->name('Get DISTRIBUTOR Chart Setting Three');
    Route::get('get_distributor_chart_setting_six', [DashboardDistributorDisplaySettingController::class, 'getChartSettingSix'])->name('Get DISTRIBUTOR Chart Setting Six');
    Route::get('get_distributor_chart_setting_seven', [DashboardDistributorDisplaySettingController::class, 'getChartSettingSeven'])->name('Get DISTRIBUTOR Chart Setting Seven');
    Route::get('get_distributor_chart_setting_eight', [DashboardDistributorDisplaySettingController::class, 'getChartSettingEight'])->name('Get DISTRIBUTOR Chart Setting Eight');
    Route::get('get_distributor_chart_setting_twelve', [DashboardDistributorDisplaySettingController::class, 'getChartSettingTwelve'])->name('Get DISTRIBUTOR Chart Setting Twelve');
    Route::get('get_distributor_chart_setting_fourteen', [DashboardDistributorDisplaySettingController::class, 'getChartSettingFourteen'])->name('Get DISTRIBUTOR Chart Setting Fourteen');
});
Route::get('koolreport_assets/{id}/{file}', function ($id, $file) {
    return File::get(public_path() . '/koolreport_assets/' . $id . "/" . $file);
});

Route::get('koolreport_assets/{id}/{dir}/{file}', function ($id, $dir, $file) {
    return File::get(public_path() . '/koolreport_assets/' . $id . "/" . $dir . "/" . $file);
});

Route::get('koolreport_assets/{id}/{dir1}/{dir2}/{file}', function ($id, $dir1, $dir2, $file) {
    return File::get(public_path() . '/koolreport_assets/' . $id . "/" . $dir1 . "/" . $dir2 . "/" . $file);
});

Route::group(['tag' => 'CPD Report'], function () {
    Route::get('cpdprogramsecretariat', [CpdModuleController::class, 'getCPDProgramSecretariatReport'])->name('GET CPD PROGRAM SECRETARIAT REPORT');
    Route::get('cpdprogramsecretariatpdf', [CpdModuleController::class, 'getCPDProgramSecretariatPortraitPdf'])->name('GET CPD PROGRAM SECRETARIAT PORTRAIT PDF');
    Route::get('cpdprogramsecretariatlandscapepdf', [CpdModuleController::class, 'getCPDProgramSecretariatLandscapePdf'])->name('GET CPD PROGRAM SECRETARIAT LANDSCAPE PDF');
    Route::get('cpdprogramsecretariatexcel', [CpdModuleController::class, 'getCPDProgramSecretariatExcel'])->name('GET CPD PROGRAM SECRETARIAT Excel');
    Route::get('cpdprogramrepeated', [CpdModuleController::class, 'getCPDProgramRepeatedReport'])->name('GET CPD PROGRAM SECRETARIAT-REPEATED REPORT');
    Route::get('cpdprogramrepeatedpdf', [CpdModuleController::class, 'getCPDProgramRepeatedPortraitPdf'])->name('GET CPD PROGRAM SECRETARIAT PORTRAIT PDF');
    Route::get('cpdprogramrepeatedlandscapepdf', [CpdModuleController::class, 'getCPDProgramRepeatedLandscapePdf'])->name('GET CPD PROGRAM SECRETARIAT LANDSCAPE PDF');
    Route::get('cpdprogramrepeatedexcel', [CpdModuleController::class, 'getCPDProgramRepeatedExcel'])->name('GET CPD PROGRAM REPEATED EXCEL');
    Route::get('cpdevaluation', [CpdModuleController::class, 'getCPDEvaluationReport'])->name('GET CPD EVALUATION REPORT');
    Route::get('cpdevaluationpdf', [CpdModuleController::class, 'getCPDEvaluationPortraitPdf'])->name('GET CPD EVALUATION PDF');
    Route::get('cpdevaluationandscapepdf', [CpdModuleController::class, 'getCPDEvaluationLandscapePdf'])->name('GET CPD EVALUATION PDF');
    Route::get('cpdevaluationexcel', [CpdModuleController::class, 'getCPDEvaluationExcel'])->name('GET CPD Evaluation Excel');
    Route::get('cpdfpamconsultant', [CpdModuleController::class, 'getCPDFpamConsultant'])->name('GET CPD FPAM REPORT');
    Route::get('cpdfpamconsultantreport', [CpdModuleController::class, 'getCPDFpamConsultantReport'])->name('GET CPD FPAM REPORT');
    Route::get('cpdfpampdf', [CpdModuleController::class, 'getCPDFpamConsultantPortraitPdf'])->name('GET CPD FPAM PDF');
    Route::get('cpdfpamlandscapepdf', [CpdModuleController::class, 'getCPDFpamConsultantLandscapePdf'])->name('GET CPD FPAM PDF');
    Route::get('cpdfpamexcel', [CpdModuleController::class, 'getCPDFpamExcel'])->name('GET CPD FPAM Excel');
    Route::get('cpdacademicconsultant', [CpdModuleController::class, 'getCPDAcademicConsultant'])->name('GET CPD ACADEMIC REPORT');
    Route::get('cpdacademicconsultantreport', [CpdModuleController::class, 'getCPDAcademicConsultantReport'])->name('GET CPD Academic REPORT');
    Route::get('cpdacademicpdf', [CpdModuleController::class, 'getCPDAcademicConsultantPortraitPdf'])->name('GET CPD ACADEMIC PDF');
    Route::get('cpdacademiclandscapepdf', [CpdModuleController::class, 'getCPDAcademicConsultantLandscapePdf'])->name('GET CPD ACADEMIC PDF');
    Route::get('cpdacademicexcel', [CpdModuleController::class, 'getCPDAcademicExcel'])->name('GET CPD ACADEMIC Excel');
    Route::get('cpdreadingconsultant', [CpdModuleController::class, 'getCPDReadingConsultant'])->name('GET CPD READING REPORT');
    Route::get('cpdreadingconsultantreport', [CpdModuleController::class, 'getCPDReadingConsultantReport'])->name('GET CPD Reading REPORT');
    Route::get('cpdreadingpdf', [CpdModuleController::class, 'getCPDReadingConsultantPortraitPdf'])->name('GET CPD READING PDF');
    Route::get('cpdreadinglandscapepdf', [CpdModuleController::class, 'getCPDReadingConsultantLandscapePdf'])->name('GET CPD READING PDF');
    Route::get('cpdreadingexcel', [CpdModuleController::class, 'getCPDReadingExcel'])->name('GET CPD READING Excel');
    Route::get('cpdteachingconsultant', [CpdModuleController::class, 'getCPDTeachingConsultant'])->name('GET CPD TEACHING REPORT');
    Route::get('cpdteachingconsultantreport', [CpdModuleController::class, 'getCPDTeachingConsultantReport'])->name('GET CPD TEACHING REPORT');
    Route::get('cpdteachingpdf', [CpdModuleController::class, 'getCPDTeachingConsultantPortraitPdf'])->name('GET CPD Teaching PDF');
    Route::get('cpdteachinglandscapepdf', [CpdModuleController::class, 'getCPDTeachingConsultantLandscapePdf'])->name('GET CPD TEACHING PDF');
    Route::get('cpdteachingexcel', [CpdModuleController::class, 'getCPDTeachingExcel'])->name('GET CPD Teaching Excel');
    Route::get('cpdwaiverconsultant', [CpdModuleController::class, 'getCPDWaiverConsultant'])->name('GET CPD Waiver REPORT');
    Route::any('cpdwaiverconsultantreport', [CpdModuleController::class, 'getCPDWaiverConsultantReport'])->name('GET CPD WAIVER REPORT');
    Route::get('cpdwaiverpdf', [CpdModuleController::class, 'getCPDWaiverConsultantPortraitPdf'])->name('GET CPD WAIVER PDF');
    Route::get('cpdwaiverlandscapepdf', [CpdModuleController::class, 'getCPDWaiverConsultantLandscapePdf'])->name('GET CPD WAIVER PDF');
    Route::get('cpdwaiverexcel', [CpdModuleController::class, 'getCPDWaiverExcel'])->name('GET CPD WAIVER Excel');
    Route::get('cpdwritingconsultant', [CpdModuleController::class, 'getCPDWritingConsultant'])->name('GET CPD Writing REPORT');
    Route::get('cpdwritingconsultantreport', [CpdModuleController::class, 'getCPDWritingConsultantReport'])->name('GET CPD Writing REPORT');
    Route::get('cpdwritingpdf', [CpdModuleController::class, 'getCPDWritingConsultantPortraitPdf'])->name('GET CPD WRITING PDF');
    Route::get('cpdwritinglandscapepdf', [CpdModuleController::class, 'getCPDWritingConsultantLandscapePdf'])->name('GET CPD WRITING PDF');
    Route::get('cpdwritingexcel', [CpdModuleController::class, 'getCPDWritingExcel'])->name('GET CPD WRITING Excel');
    Route::get('cpdrecordconsultant', [CpdModuleController::class, 'getCPDRecordConsultant'])->name('GET CPD RECORD REPORT');
    Route::get('cpdrecordconsultantreport', [CpdModuleController::class, 'getCPDRecordConsultantReport'])->name('GET CPD RECORD REPORT');
    Route::get('cpdrecordconaultantpdf', [CpdModuleController::class, 'getCPDRecordConsultantPortraitPdf'])->name('GET CPD CONSULTANT PDF');
    Route::get('cpdrecordconsultantlandscapepdf', [CpdModuleController::class, 'getCPDRecordConsultantLandscapePdf'])->name('GET CPD CONSULTANT PDF');
    Route::get('cpdrecordconsultantexcel', [CpdModuleController::class, 'getCPDRecordConsultantExcel'])->name('GET CPD CONSULTANT Excel');
    Route::get('cpdrecord', [CpdModuleController::class, 'getCPDRecord'])->name('GET CPD RECORD REPORT');
    Route::get('cpdrecordprogramreport', [CpdModuleController::class, 'getCPDRecordParticipantReport'])->name('GET CPD RECORD REPORT');
    Route::get('cpdrecordpdf', [CpdModuleController::class, 'getCPDRecordPortraitPdf'])->name('GET CPD RECORD PDF');
    Route::get('cpdrecordlandscapepdf', [CpdModuleController::class, 'getCPDRecordLandscapePdf'])->name('GET CPD RECORD PDF');
    Route::get('cpdrecordexcel', [CpdModuleController::class, 'getCPDRecordExcel'])->name('GET CPD RECORD Excel');
});
Route::group(['tag' => 'Finance Report'], function () {
    Route::any('financeutcreport', [FinanceReportController::class, 'getFinanceUtcReport'])->name('GET Finance UTC REPORT');
    Route::any('financeutcpdf', [FinanceReportController::class, 'getFinanceUtcPortraitPdf'])->name('GET Finance UTC PDF');
    Route::any('finaceutclandscapepdf', [FinanceReportController::class, 'getFinanceUtcLandscapePdf'])->name('GET FINANCE UTC PDF');
    Route::any('financeutcexcel', [FinanceReportController::class, 'getFinanceUtcExcel'])->name('GET FINANCE UTC Excel');
    Route::any('financeprcreport', [FinanceReportController::class, 'getFinancePrcReport'])->name('GET Finance PRC REPORT');
    Route::any('financeprcpdf', [FinanceReportController::class, 'getFinancePrcPortraitPdf'])->name('GET Finance PRC PDF');
    Route::any('finaceprclandscapepdf', [FinanceReportController::class, 'getFinancePrcLandscapePdf'])->name('GET FINANCE PRC PDF');
    Route::any('financeprcexcel', [FinanceReportController::class, 'getFinancePrcExcel'])->name('GET FINANCE PRC Excel');
    Route::any('financeutcsummaryreport', [FinanceReportController::class, 'getFinanceUtcSummaryReport'])->name('GET Finance UTC Summary REPORT');
    Route::any('financeutcsummarypdf', [FinanceReportController::class, 'getFinanceUtcSummaryPortraitPdf'])->name('GET Finance UTC Summary PDF');
    Route::any('finaceutcsummarylandscapepdf', [FinanceReportController::class, 'getFinanceUtcSummaryLandscapePdf'])->name('GET FINANCE UTC PDF');
    Route::any('financeutcsummaryexcel', [FinanceReportController::class, 'getFinanceUtcSummaryExcel'])->name('GET FINANCE UTC Summary Excel');
    Route::any('financeamsfcollectionreport', [FinanceReportController::class, 'getFinanceAMSFCollectionReport'])->name('GET Finance AMSF Collection REPORT');
    Route::any('financeamsfcollectionexcel', [FinanceReportController::class, 'getFinanceAmsfCollectionExcel'])->name('GET FINANCE AMSF Collection Excel');
});
Route::group(['tag' => 'Admin Report'], function () {
    Route::any('adminuserlist', [AdminReportController::class, 'getAdminUserReport'])->name('GET Admin User List REPORT');
    Route::get('adminuserlistpdf', [AdminReportController::class, 'getAdminUserPortraitPdf'])->name('GET ADMIN USER PDF');
    Route::get('adminuserlistlandscapepdf', [AdminReportController::class, 'getAdminUserLandscapePdf'])->name('GET ADMIN USER PDF');
    Route::get('adminuserlistexcel', [AdminReportController::class, 'getAdminUserExcel'])->name('GET ADMIN USER Excel');
    Route::any('adminsmslogreport', [AdminReportController::class, 'getAdminSmsLogReport'])->name('GET  Admin SMS LOG REPORT');
    Route::get('adminsmslogpdf', [AdminReportController::class, 'getAdminSmsLogReportPdf'])->name('GET ADMIN SMS LOG PDF');
    Route::get('adminsmsloglandscapepdf', [AdminReportController::class, 'getAdminSmsLogReportLandscapePdf'])->name('GET ADMIN SMS LOG PDF');
    Route::get('adminsmslogexcel', [AdminReportController::class, 'getAdminSmsLogReportExcel'])->name('GET ADMIN SMS LOG Excel');
    Route::any('adminsummarysmslogreport', [AdminReportController::class, 'getAdminSummarySmsLogReport'])->name('GET  Admin SMS LOG REPORT');
    Route::get('adminsummarysmslogpdf', [AdminReportController::class, 'getAdminSummarySmsLogReportPdf'])->name('GET FADMIN SMS LOG PDF');
    Route::get('adminsummarysmsloglandscapepdf', [AdminReportController::class, 'getAdminSummarySmsLogReportLandscapePdf'])->name('GET ADMIN SMS LOG PDF');
    Route::get('adminsummarysmslogexcel', [AdminReportController::class, 'getAdminSummarySmsLogReportExcel'])->name('GET ADMIN SMS LOG Excel');
    Route::any('adminscreenmngtreport', [AdminReportController::class, 'getAdminScreenManagementReport'])->name('GET  SCREEN MANAGEMENT REPORT');
    Route::any('adminscreenmngpdf', [AdminReportController::class, 'getAdminScreenManagementReportPdf'])->name('GET ADMIN SCREEN MANAGEMENT PDF');
    Route::any('adminscreenmnglandscapepdf', [AdminReportController::class, 'getAdminScreenManagementReportLandscapePdf'])->name('GET ADMIN SCREEN MANAGEMENT PDF');
    Route::any('adminscreenmngexcel', [AdminReportController::class, 'getAdminScreenManagementReportExcel'])->name('GET ADMIN SCREEN Excel');
    Route::any('adminaddressmngtreport', [AdminReportController::class, 'getAdminAddressManagementReport'])->name('GET  ADDRESS MANAGEMENT REPORT');
    Route::any('adminaddressmngpdf', [AdminReportController::class, 'getAdminAddressManagementReportPdf'])->name('GET ADMIN ADDRESS MANAGEMENT PDF');
    Route::any('adminaddressmnglandscapepdf', [AdminReportController::class, 'getAdminAddressManagementReportLandscapePdf'])->name('GET ADDRESS  MANAGEMENT PDF');
    Route::any('adminaddressmngexcel', [AdminReportController::class, 'getAdminAddressManagementReportExcel'])->name('GET ADMIN ADDRESS Excel');
    Route::any('admincalendarmngtreport', [AdminReportController::class, 'getAdminCalendarManagementReport'])->name('GET  CALENDAR MANAGEMENT REPORT');
    Route::any('admincalendarmngpdf', [AdminReportController::class, 'getAdminCalendarManagementReportPdf'])->name('GET ADMIN CALENDAR MANAGEMENT PDF');
    Route::any('admincalendarmnglandscapepdf', [AdminReportController::class, 'getAdminCalendarManagementReportLandscapePdf'])->name('GET CALENDAR  MANAGEMENT PDF');
    Route::any('admincalendarmngexcel', [AdminReportController::class, 'getAdminCalendarManagementReportExcel'])->name('GET ADMIN CALENDAR Excel');
    Route::any('adminsalutationreport', [AdminReportController::class, 'getAdminSalutationReport'])->name('GET  SALUTATION REPORT');
    Route::any('adminsalutationpdf', [AdminReportController::class, 'getAdminSalutationReportPdf'])->name('GET ADMIN SALUTATION  PDF');
    Route::any('adminsalutationlandscapepdf', [AdminReportController::class, 'getAdminSalutationReportLandscapePdf'])->name('GET SALUTATION PDF');
    Route::any('adminsalutationexcel', [AdminReportController::class, 'getAdminSalutationReportExcel'])->name('GET SALUTATION Excel');
    Route::any('admindeclarationreport', [AdminReportController::class, 'getAdminDeclarationReport'])->name('GET  Declaration REPORT');
    Route::any('admindeclarationpdf', [AdminReportController::class, 'getAdminDeclarationReportPdf'])->name('GET ADMIN DECLARATION  PDF');
    Route::any('admindeclarationlandscapepdf', [AdminReportController::class, 'getAdminDeclarationReportLandscapePdf'])->name('GET DECLARATION PDF');
    Route::any('admindeclarationexcel', [AdminReportController::class, 'getAdminDeclarationReportExcel'])->name('GET DECLARATION Excel');
    Route::any('adminfeemanagementreport', [AdminReportController::class, 'getAdminFeeManagementReport'])->name('GET Fee Management REPORT');
    Route::any('adminfeemngpdf', [AdminReportController::class, 'getAdminFeeReportPdf'])->name('GET ADMIN FEE  PDF');
    Route::any('adminfeemnglandscapepdf', [AdminReportController::class, 'getAdminFeeReportLandscapePdf'])->name('GET FEE PDF');
    Route::any('adminfeemngexcel', [AdminReportController::class, 'getAdminFeeReportExcel'])->name('GET FEE Excel');
    Route::any('admincircularmanagementreport', [AdminReportController::class, 'getAdminCircularManagementReport'])->name('GET Circular Management REPORT');
    Route::any('admincircularmngpdf', [AdminReportController::class, 'getAdminCircularReportPdf'])->name('GET ADMIN CURCULAR  PDF');
    Route::any('admincircularmnglandscapepdf', [AdminReportController::class, 'getAdminCircularReportLandscapePdf'])->name('GET CIRCULAR PDF');
    Route::any('admincircularmngexcel', [AdminReportController::class, 'getAdminCircularReportExcel'])->name('GET CURCULAR Excel');
    Route::any('adminannouncementmanagementreport', [AdminReportController::class, 'getAdminAnnouncementManagementReport'])->name('GET Announcement Management REPORT');
    Route::any('adminannouncementmngpdf', [AdminReportController::class, 'getAdminAnnouncementReportPdf'])->name('GET ADMIN Announcement  PDF');
    Route::any('adminannouncementmnglandscapepdf', [AdminReportController::class, 'getAdminAnnouncementReportLandscapePdf'])->name('GET Announcement PDF');
    Route::any('adminannouncementmngexcel', [AdminReportController::class, 'getAdminAnnouncementReportExcel'])->name('GET Announcement Excel');
    Route::any('adminusermatrixreport', [AdminReportController::class, 'getAdminUserMatrixReport'])->name('GET User Matrix REPORT');
    Route::any('adminusermatrixpdf', [AdminReportController::class, 'getAdminUserMatrixReportPdf'])->name('GET ADMIN USER MATRIX  PDF');
    Route::any('adminusermatrixlandscapepdf', [AdminReportController::class, 'getAdminUserMatrixReportLandscapePdf'])->name('GET USER MATRIX PDF');
    Route::any('adminusermatrixexcel', [AdminReportController::class, 'getAdminUserMatrixReportExcel'])->name('GET USER MATRIX Excel');
    Route::any('adminuserdetailreport', [AdminReportController::class, 'getAdminUserDetailReport'])->name('GET Admin User Detail REPORT');
    Route::any('adminfinancecodereport', [AdminReportController::class, 'getAdminFinanceCodeReport'])->name('GET Admin Finance Code REPORT');
    Route::any('adminfinancecodepdf', [AdminReportController::class, 'getAdminFinanceCodeReportPdf'])->name('GET ADMIN Finance Code  PDF');
    Route::any('adminfinancecodelandscapepdf', [AdminReportController::class, 'getAdminFinanceReportLandscapePdf'])->name('GET Finance Code PDF');
    Route::any('adminfinancecodeexcel', [AdminReportController::class, 'getAdminFinaceCodeReportExcel'])->name('GET Finance Code Excel');
    Route::any('adminidmaskingreport', [AdminReportController::class, 'getAdminIDMaskingReport'])->name('GET Admin ID MASKING REPORT');
    Route::any('adminidmaskingpdf', [AdminReportController::class, 'getAdminIDMaskingReportPdf'])->name('GET ADMIN ID Masking  PDF');
    Route::any('adminidmaskinglandscapepdf', [AdminReportController::class, 'getAdminIDMaskingReportLandscapePdf'])->name('GET ID Masking PDF');
    Route::any('adminidmaskingexcel', [AdminReportController::class, 'getAdminIDMaskingReportExcel'])->name('GET ID Masking Excel');
    Route::any('admintemplatelistreport', [AdminReportController::class, 'getAdminTemplateListReport'])->name('GET Admin Template List REPORT');
    Route::any('myreport', [AdminReportController::class, 'index'])->name('GET Admin Template List REPORT');
    Route::any('myreportpdf', [AdminReportController::class, 'myreportPdf'])->name('GET Admin Template List REPORT');
    Route::any('adminuserdetailpdf', [AdminReportController::class, 'getAdminFimmUserDetailReportPdf'])->name('GET ADMIN FIMM USER DETAIL  PDF');
    Route::any('adminuserdetaillandscapepdf', [AdminReportController::class, 'getAdminFimmUserDetailReportLandscapePdf'])->name('GET FIMM USER DETAIL');
    Route::any('adminuserdetailexcel', [AdminReportController::class, 'getAdminFimmUserDetailReportExcel'])->name('GET FIMM USER DETAIL Excel');
    Route::any('admindistuserdetailpdf', [AdminReportController::class, 'getAdminDistUserDetailReportPdf'])->name('GET ADMIN DISTRIBUTOR USER DETAIL  PDF');
    Route::any('admindistuserdetaillandscapepdf', [AdminReportController::class, 'getAdminDistUserDetailReportLandscapePdf'])->name('GET DISTRIBUTOR USER DETAIL');
    Route::any('admindistuserdetailexcel', [AdminReportController::class, 'getAdminDistUserDetailReportExcel'])->name('GET DISTRIBUTOR USER DETAIL Excel');
    Route::any('adminconuserdetailpdf', [AdminReportController::class, 'getAdminConUserDetailReportPdf'])->name('GET ADMIN CONSULTANT USER DETAIL  PDF');
    Route::any('adminconuserdetaillandscapepdf', [AdminReportController::class, 'getAdminConUserDetailReportLandscapePdf'])->name('GET CONSULTANT USER DETAIL');
    Route::any('adminconuserdetailexcel', [AdminReportController::class, 'getAdminConUserDetailReportExcel'])->name('GET CONSULTANT USER DETAIL Excel');
    Route::any('adminotheruserdetailpdf', [AdminReportController::class, 'getAdminOtherUserDetailReportPdf'])->name('GET ADMIN Others USER DETAIL  PDF');
    Route::any('adminotheruserdetaillandscapepdf', [AdminReportController::class, 'getAdminOtherUserDetailReportLandscapePdf'])->name('GET Others USER DETAIL');
    Route::any('adminotheruserdetailexcel', [AdminReportController::class, 'getAdminOtherUserDetailReportExcel'])->name('GET Others USER DETAIL Excel');
    Route::any('adminusersummary', [AdminReportController::class, 'getAdminUserSummaryReport'])->name('GET Admin User Summary REPORT');
    Route::get('adminusersummarypdf', [AdminReportController::class, 'getAdminUserSummaryPortraitPdf'])->name('GET ADMIN USER PDF');
    Route::get('adminusersummarylandscapepdf', [AdminReportController::class, 'getAdminUserSummaryLandscapePdf'])->name('GET ADMIN USER PDF');
    Route::get('adminusersummaryexcel', [AdminReportController::class, 'getAdminUserSummaryExcel'])->name('GET ADMIN USER Excel');
    Route::any('adminuserlogreport', [AdminReportController::class, 'getAdminUserLogReport'])->name('GET Admin User Log REPORT');
    Route::any('adminuserlogexcel', [AdminReportController::class, 'getAdminUserLogExcel'])->name('GET ADMIN USER Log Excel');
    Route::any('adminapprovalreport', [AdminReportController::class, 'getAdminApprovalReport'])->name('GET Admin Approval REPORT');
    Route::any('adminapprovalexcel', [AdminReportController::class, 'getAdminApprovalExcel'])->name('GET ADMIN Approval Excel');
    //Route::any('admintemplatefiledownload', [AdminReportController::class, 'downloadAdminTemplate'])->name('GET Admin Approval REPORT');
    Route::any('admintemplatefiledownload', [AdminReportController::class, 'getAdminTemplateFileDownload'])->name('GET ADMIN USER Excel');
    Route::any('admintemplatelistexcel', [AdminReportController::class, 'getAdminTemplateListExcel'])->name('GET Admin Template List REPORT');
});
Route::group(['tag' => 'Consultant Management Report'], function () {
    Route::any('consultantdetailreport', [ConsultantManagementReportController::class, 'getConsultantDetailReportReport'])->name('GET Consultant Detail REPORT');
    Route::any('consultantdetailpdf', [ConsultantManagementReportController::class, 'getConsultantDetailPortraitPdf'])->name('GET CONSULTANT DETAIL PDF');
    Route::any('consultantdetaillandscapepdf', [ConsultantManagementReportController::class, 'getConsultantDetailLandscapePdf'])->name('GET CONSULTANT DETAIL  PDF');
    Route::any('consultantdetailexcel', [ConsultantManagementReportController::class, 'getConsultantDetailExcel'])->name('GET CONSULTANT DETAIL Excel');
    Route::any('consultantregistrationreport', [ConsultantManagementReportController::class, 'getConsultantRegistrationReport'])->name('GET Consultant REGISTRATION REPORT');
    Route::any('consultantregistrationpdf', [ConsultantManagementReportController::class, 'getConsultantRegistrationPortraitPdf'])->name('GET CONSULTANT REGISTRATION PDF');
    Route::any('consultantregistrationlandscapepdf', [ConsultantManagementReportController::class, 'getConsultantRegistrationLandscapePdf'])->name('GET CONSULTANT REGISTRATION  PDF');
    Route::any('consultantregistrationexcel', [ConsultantManagementReportController::class, 'getConsultantRegistrationExcel'])->name('GET CONSULTANT REGISTRATION Excel');
    Route::any('consultantregistrationsummaryreport', [ConsultantManagementReportController::class, 'getConsultantRegistrationSummaryReport'])->name('GET Consultant REGISTRATION Summary REPORT');
    Route::any('consultantregistrationsummarypdf', [ConsultantManagementReportController::class, 'getConsultantRegistrationSummaryPortraitPdf'])->name('GET CONSULTANT REGISTRATION SUMMARY PDF');
    Route::any('consultantregistrationsummarylandscapepdf', [ConsultantManagementReportController::class, 'getConsultantRegistrationSummaryLandscapePdf'])->name('GET CONSULTANT REGISTRATION SUMMARY  PDF');
    Route::any('consultantregistrationsummaryexcel', [ConsultantManagementReportController::class, 'getConsultantRegistrationSummaryExcel'])->name('GET CONSULTANT REGISTRATION SUMMARY Excel');
    Route::any('consultantterminationreport', [ConsultantManagementReportController::class, 'getConsultantTerminationReport'])->name('GET Consultant Termination REPORT');
    Route::any('consultantterminationpdf', [ConsultantManagementReportController::class, 'getConsultantTerminationPortraitPdf'])->name('GET CONSULTANT TERMINATION PDF');
    Route::any('consultantterminationlandscapepdf', [ConsultantManagementReportController::class, 'getConsultantTerminationLandscapePdf'])->name('GET CONSULTANT TERMINATION  PDF');
    Route::any('consultantterminationexcel', [ConsultantManagementReportController::class, 'getConsultantTerminationExcel'])->name('GET CONSULTANT TERMINATION Excel');
    Route::any('consultantterminationsummaryreport', [ConsultantManagementReportController::class, 'getConsultantTerminationSummaryReport'])->name('GET Consultant Termination Summary REPORT');
    Route::any('consultantterminationsummarypdf', [ConsultantManagementReportController::class, 'getConsultantTerminationSummaryPortraitPdf'])->name('GET CONSULTANT TERMINATION SUMMARY PDF');
    Route::any('consultantterminationsummarylandscapepdf', [ConsultantManagementReportController::class, 'getConsultantTerminationSummaryLandscapePdf'])->name('GET CONSULTANT TERMINATION SUMMARY PDF');
    Route::any('consultantterminationsummaryexcel', [ConsultantManagementReportController::class, 'getConsultantTerminationSummaryExcel'])->name('GET CONSULTANT TERMINATION SUMMARY Excel');
    Route::any('consultantactivereport', [ConsultantManagementReportController::class, 'getConsultantActiveReport'])->name('GET Consultant Active REPORT');
    Route::any('consultantactivepdf', [ConsultantManagementReportController::class, 'getConsultantActivePortraitPdf'])->name('GET CONSULTANT ACTIVE PDF');
    Route::any('consultantactivelandscapepdf', [ConsultantManagementReportController::class, 'getConsultantActiveLandscapePdf'])->name('GET CONSULTANT Active PDF');
    Route::any('consultantactiveexcel', [ConsultantManagementReportController::class, 'getConsultantActiveExcel'])->name('GET CONSULTANT Active Excel');
    Route::any('consultantactivesummaryreport', [ConsultantManagementReportController::class, 'getConsultantActiveSummaryReport'])->name('GET Consultant Active Summary REPORT');
    Route::any('consultantactivesummarypdf', [ConsultantManagementReportController::class, 'getConsultantActiveSummaryPortraitPdf'])->name('GET CONSULTANT ACTIVE PDF');
    Route::any('consultantactivesummarylandscapepdf', [ConsultantManagementReportController::class, 'getConsultantActiveSummaryLandscapePdf'])->name('GET CONSULTANT Active PDF');
    Route::any('consultantactivesummaryexcel', [ConsultantManagementReportController::class, 'getConsultantActiveSummaryExcel'])->name('GET CONSULTANT Active Excel');
    Route::any('consultantbankruptcyreport', [ConsultantManagementReportController::class, 'getConsultantBankruptcyReport'])->name('GET Consultant Bankruptcy REPORT');
});

Route::group(['tag' => 'Distributor Management Report'], function () {
    Route::any('distributorinformationreport', [DistributorManagementReportController::class, 'getDistributorInformationReport'])->name('GET Distributor Information REPORT');
    Route::any('distributorinformationexcel', [DistributorManagementReportController::class, 'getDistributorInformationExcelReport'])->name('GET Distributor Information REPORT');
    Route::any('distributortypesummaryreport', [DistributorManagementReportController::class, 'getDistributorTypeSummaryReport'])->name('GET Distributor Type Summary REPORT');
    Route::any('distributortypesummarypdf', [DistributorManagementReportController::class, 'getDistributorTypeSummaryPortraitPdf'])->name('GET Distributor Type PDF');
    Route::any('distributortypesummarylandscapepdf', [DistributorManagementReportController::class, 'getDistributorTypeSummaryLandscapePdf'])->name('GET Distributor Type PDF');
    Route::any('distributortypesummaryexcel', [DistributorManagementReportController::class, 'getDistributorTypeSummaryExcel'])->name('GET Distributor Type Excel');
    Route::any('distributorpointsreport', [DistributorManagementReportController::class, 'getDistributorPointsReport'])->name('GET Distributor Points REPORT');
    Route::any('distributorpointpdf', [DistributorManagementReportController::class, 'getDistributorPointPortraitPdf'])->name('GET Distributor Point PDF');
    Route::any('distributorpointlandscapepdf', [DistributorManagementReportController::class, 'getDistributorPointLandscapePdf'])->name('GET Distributor Point PDF');
    Route::any('distributorpointexcel', [DistributorManagementReportController::class, 'getDistributorPointExcel'])->name('GET Distributor Point Excel');
    Route::any('distributorpointconsultantreport', [DistributorManagementReportController::class, 'getDistributorPointConsultantReport'])->name('GET Distributor Consultant By Points  REPORT');
    Route::any('distributorpointconsultantpdf', [DistributorManagementReportController::class, 'getDistributorPointConsultantPortraitPdf'])->name('GET Distributor Point PDF');
    Route::any('distributorpointconsultantlandscapepdf', [DistributorManagementReportController::class, 'getDistributorPointConsultantLandscapePdf'])->name('GET Distributor Point PDF');
    Route::any('distributorpointconsultantexcel', [DistributorManagementReportController::class, 'getDistributorPointConsultantExcel'])->name('GET Distributor Point Excel');
    Route::any('consultantbydistributorpointsreport', [DistributorManagementReportController::class, 'getDistributorPointByConsultantReport'])->name('GET Distributor Consultant By Points  REPORT');
    Route::any('distributorpointbyconsultantpdf', [DistributorManagementReportController::class, 'getDistributorPointByConsultantPortraitPdf'])->name('GET Distributor Point By Consultant PDF');
    Route::any('distributorpointbyconsultantlandscapepdf', [DistributorManagementReportController::class, 'getDistributorPointByConsultantLandscapePdf'])->name('GET Distributor Point By Consultant PDF');
    Route::any('distributorpointbyconsultantexcel', [DistributorManagementReportController::class, 'getDistributorPointByConsultantExcel'])->name('GET Distributor Point By Consultant Excel');
    Route::any('preregbankruptcyreport', [DistributorManagementReportController::class, 'getDistributorPreRegBankruptcyReport'])->name('GET Distributor Pre Reg Bankruptcy  REPORT');
    Route::any('distributorprebankruptcypdf', [DistributorManagementReportController::class, 'getDistributorPreBankruptcyPortraitPdf'])->name('GET Distributor Pre Reg Bankruptcy PDF');
    Route::any('distributorprebankruptcylandscapepdf', [DistributorManagementReportController::class, 'getDistributorPreBankruptcyLandscapePdf'])->name('GET Distributor Pre Reg Bankruptcy PDF');
    Route::any('distributorprebankruptcyexcel', [DistributorManagementReportController::class, 'getDistributorPreBankruptcyExcel'])->name('GET Distributor Pre Reg Bankruptcy Excel');
    Route::any('distributorfundlodgementreport', [DistributorManagementReportController::class, 'getDistributorFundlodgementReport'])->name('GET Distributor Fundlodgement  REPORT');
    Route::any('distributorfundlodgementpdf', [DistributorManagementReportController::class, 'getDistributorFundlodgementPortraitPdf'])->name('GET Distributor FundLodgement PDF');
    Route::any('distributorfundlodgementlandscapepdf', [DistributorManagementReportController::class, 'getDistributorFundlodgementLandscapePdf'])->name('GET Distributor FundLodgement PDF');
    Route::any('distributorfundlodgementexcel', [DistributorManagementReportController::class, 'getDistributorFundlodgementExcel'])->name('GET Distributor FundLodgement Excel');
});
Route::group(['tag' => 'Fund Management Report'], function () {
    Route::any('funddailynavreport', [FundManagementReportController::class, 'getFundDailyNavReport'])->name('GET Fund Daily Nav REPORT');
    Route::any('funddailynavpdf', [FundManagementReportController::class, 'getFundDailyNavPortraitPdf'])->name('GET Fund Daily Nav Portrait PDF REPORT');
    Route::any('funddailynavlandscapepdf', [FundManagementReportController::class, 'getFundDailyNavLandscapePdf'])->name('GET Fund Daily Nav Landscape Pdf REPORT');
    Route::any('funddailynavexcel', [FundManagementReportController::class, 'getFundDailyNavExcel'])->name('GET Fund Daily Nav Excel REPORT');
    Route::any('funddailynavadminreport', [FundManagementReportController::class, 'getFundDailyNavAdminReport'])->name('GET Fund Daily Nav ADMIN REPORT');
    Route::any('funddailynavadminpdf', [FundManagementReportController::class, 'getFundDailyNavAdminPortraitPdf'])->name('GET Fund Daily Nav Admin Portrait PDF REPORT');
    Route::any('funddailynavadminlandscapepdf', [FundManagementReportController::class, 'getFundDailyNavAdminLandscapePdf'])->name('GET Fund Daily Nav Admin Landscape Pdf REPORT');
    Route::any('funddailynavadminexcel', [FundManagementReportController::class, 'getFundDailyNavAdminExcel'])->name('GET Fund Daily Nav Admin Excel REPORT');
    Route::any('fundhistoricalnavreport', [FundManagementReportController::class, 'getFundHistoricalNavReport'])->name('GET Fund Historical Nav REPORT');
    Route::any('fundhistoricalnavpdf', [FundManagementReportController::class, 'getFundHistoricalNavPortraitPdf'])->name('GET Fund Historical Nav Portrait PDF REPORT');
    Route::any('fundhistoricalnavlandscapepdf', [FundManagementReportController::class, 'getFundHistoricalNavLandscapePdf'])->name('GET Fund Historical Nav Landscape Pdf REPORT');
    Route::any('fundhistoricalnavexcel', [FundManagementReportController::class, 'getFundHistoricalNavExcel'])->name('GET Fund Historical Nav Excel REPORT');
    Route::any('fundhistoricalnavdetailreport', [FundManagementReportController::class, 'getFundHistoricalNavDetailReport'])->name('GET Fund Historical Nav Detail REPORT');
    Route::any('fundhistoricalnavdetailpdf', [FundManagementReportController::class, 'getFundHistoricalNavDetailPortraitPdf'])->name('GET Fund Historical Nav Detail Portrait PDF REPORT');
    Route::any('fundhistoricalnavdetaillandscapepdf', [FundManagementReportController::class, 'getFundHistoricalNavDetailLandscapePdf'])->name('GET Fund Historical Nav Detail Landscape Pdf REPORT');
    Route::any('fundhistoricalnavdetailexcel', [FundManagementReportController::class, 'getFundHistoricalNavDetailExcel'])->name('GET Fund Historical Nav Detail Excel REPORT');
    Route::any('fundhistoricalnavuserreport', [FundManagementReportController::class, 'getFundHistoricalNavMemberReport'])->name('GET Fund Historical Nav Member REPORT');
    Route::any('fundhistoricalnavmemberpdf', [FundManagementReportController::class, 'getFundHistoricalNavMemberPortraitPdf'])->name('GET Fund Historical Nav Member Portrait PDF REPORT');
    Route::any('fundhistoricalnavmemberlandscapepdf', [FundManagementReportController::class, 'getFundHistoricalNavMemberLandscapePdf'])->name('GET Fund Historical Nav Member Landscape Pdf REPORT');
    Route::any('fundhistoricalnavmemberexcel', [FundManagementReportController::class, 'getFundHistoricalNavMemberExcel'])->name('GET Fund Historical Nav Member Excel REPORT');
    Route::any('funddatanewreport', [FundManagementReportController::class, 'getFundDataNewReport'])->name('GET Fund Data New REPORT');
    Route::any('funddatanewpdf', [FundManagementReportController::class, 'getFundDataNewPortraitPdf'])->name('GET Fund Data New Portrait PDF REPORT');
    Route::any('funddatanewlandscapepdf', [FundManagementReportController::class, 'getFundDataNewLandscapePdf'])->name('GET Fund Data New Landscape Pdf REPORT');
    Route::any('funddatanewexcel', [FundManagementReportController::class, 'getFundDataNewExcel'])->name('GET Fund Data New Excel REPORT');
    Route::any('funddataclosedreport', [FundManagementReportController::class, 'getFundDataClosedReport'])->name('GET Fund Data Closed REPORT');
    Route::any('funddataclosedpdf', [FundManagementReportController::class, 'getFundDataClosedPortraitPdf'])->name('GET Fund Data Closed Portrait PDF REPORT');
    Route::any('funddataclosedlandscapepdf', [FundManagementReportController::class, 'getFundDataClosedLandscapePdf'])->name('GET Fund Data Closed Landscape Pdf REPORT');
    Route::any('funddataclosedexcel', [FundManagementReportController::class, 'getFundDataClosedExcel'])->name('GET Fund Data Closed Excel REPORT');
    Route::any('funddatastatusreport', [FundManagementReportController::class, 'getFundDataStatusReport'])->name('GET Fund Data Status REPORT');
    Route::any('funddatastatuspdf', [FundManagementReportController::class, 'getFundDataStatusPortraitPdf'])->name('GET Fund Data Status Portrait PDF REPORT');
    Route::any('funddatastatuslandscapepdf', [FundManagementReportController::class, 'getFundDataStatusLandscapePdf'])->name('GET Fund Data Status Landscape Pdf REPORT');
    Route::any('funddatastatusexcel', [FundManagementReportController::class, 'getFundDataStatusExcel'])->name('GET Fund Data Status Excel REPORT');
    Route::any('funddataepfreport', [FundManagementReportController::class, 'getFundDataEPFReport'])->name('GET Fund Data EPF REPORT');
    Route::any('funddataepfpdf', [FundManagementReportController::class, 'getFundDataEPFPortraitPdf'])->name('GET Fund Data EPF Portrait PDF REPORT');
    Route::any('funddataepflandscapepdf', [FundManagementReportController::class, 'getFundDataEPFLandscapePdf'])->name('GET Fund Data EPF Landscape Pdf REPORT');
    Route::any('funddataepfexcel', [FundManagementReportController::class, 'getFundDataEPFExcel'])->name('GET Fund Data EPF Excel REPORT');
    Route::any('funddataSRIreport', [FundManagementReportController::class, 'getFundDataSRIReport'])->name('GET Fund Data SRI REPORT');
    Route::any('funddataSRIpdf', [FundManagementReportController::class, 'getFundDataSRIPortraitPdf'])->name('GET Fund Data SRI Portrait PDF REPORT');
    Route::any('funddataSRIlandscapepdf', [FundManagementReportController::class, 'getFundDataSRILandscapePdf'])->name('GET Fund Data SRI Landscape Pdf REPORT');
    Route::any('funddataSRIexcel', [FundManagementReportController::class, 'getFundDataSRIExcel'])->name('GET Fund User Summary Excel REPORT');
    Route::any('fundusersummaryreport', [FundManagementReportController::class, 'getFundUserSummaryReport'])->name('GET Fund User Summary REPORT');
    Route::any('fundusersummarypdf', [FundManagementReportController::class, 'getFundUserSummaryPortraitPdf'])->name('GET Fund User Summary Portrait PDF REPORT');
    Route::any('fundusersummarylandscapepdf', [FundManagementReportController::class, 'getFundUserSummaryLandscapePdf'])->name('GET Fund User Summary Landscape Pdf REPORT');
    Route::any('fundusersummaryexcel', [FundManagementReportController::class, 'getFundUserSummaryExcel'])->name('GET Fund User Summary Excel REPORT');
    Route::any('fundusersummaryfimmreport', [FundManagementReportController::class, 'getFundUserSummaryFimmReport'])->name('GET Fund User Summary Fimm REPORT');
    Route::any('fundusersummaryfimmpdf', [FundManagementReportController::class, 'getFundUserSummaryFimmPortraitPdf'])->name('GET Fund User Summary Fimm Portrait PDF REPORT');
    Route::any('fundusersummaryfimmlandscapepdf', [FundManagementReportController::class, 'getFundUserSummaryFimmLandscapePdf'])->name('GET Fund User Summary Fimm Landscape Pdf REPORT');
    Route::any('fundusersummaryfimmexcel', [FundManagementReportController::class, 'getFundUserSummaryFimmExcel'])->name('GET Fund User Summary Fimm Excel REPORT');
    Route::any('fundutmccontactpersonreport', [FundManagementReportController::class, 'getFundUTMCContactPersonReport'])->name('GET Fund UTMC CONTACT PERSON REPORT');
    Route::any('fundutmccontactpersonpdf', [FundManagementReportController::class, 'getFundUTMCContactPersonPortraitPdf'])->name('GET Fund UTMC Contact Person Portrait PDF REPORT');
    Route::any('fundutmccontactpersonlandscapepdf', [FundManagementReportController::class, 'getFundUTMCContactPersonLandscapePdf'])->name('GET FundUTMC Contact Person Landscape Pdf REPORT');
    Route::any('fundutmccontactpersonexcel', [FundManagementReportController::class, 'getFundUTMCContactPersonExcel'])->name('GET Fund UTMC Contact Person Excel REPORT');
    Route::any('fundnewspapercontactreport', [FundManagementReportController::class, 'getFundNewspaperContactReport'])->name('GET Fund Newspaper CONTACT PERSON REPORT');
    Route::any('fundnewspapercontactpdf', [FundManagementReportController::class, 'getFundNewspaperContactPortraitPdf'])->name('GET Fund Newspaper Contact Person Portrait PDF REPORT');
    Route::any('fundnewspapercontactlandscapepdf', [FundManagementReportController::class, 'getFundNewspaperContactLandscapePdf'])->name('GET Fund Newspaper Contact Person Landscape Pdf REPORT');
    Route::any('fundnewspapercontactexcel', [FundManagementReportController::class, 'getFundNewspaperContactExcel'])->name('GET Fund Newspaper Contact Person Excel REPORT');
    Route::any('fundeventlogreport', [FundManagementReportController::class, 'getFundEventLogReport'])->name('GET Fund Event Log REPORT');
    Route::any('fundeventlogpdf', [FundManagementReportController::class, 'getFundEventLogPortraitPdf'])->name('GET Fund Event Log Portrait PDF REPORT');
    Route::any('fundeventloglandscapepdf', [FundManagementReportController::class, 'getFundEventLogLandscapePdf'])->name('GET Fund Event Log Landscape Pdf REPORT');
    Route::any('fundeventlogexcel', [FundManagementReportController::class, 'getFundEventLogExcel'])->name('GET Fund Event Log Excel REPORT');
    Route::any('funddataallreport', [FundManagementReportController::class, 'getFundDataAllReport'])->name('GET Fund Data All REPORT');
    Route::any('funddataallpdf', [FundManagementReportController::class, 'getFundDataAllPortraitPdf'])->name('GET Fund Data All Portrait PDF REPORT');
    Route::any('funddataalllandscapepdf', [FundManagementReportController::class, 'getFundDataAllLandscapePdf'])->name('GET Fund Data All Landscape Pdf REPORT');
    Route::any('funddataallexcel', [FundManagementReportController::class, 'getFundDataAllExcel'])->name('GET Fund Data All Excel REPORT');
    Route::any('fundaudittrailreport', [FundManagementReportController::class, 'getFundAuditTrailReport'])->name('GET Fund Audit Trail REPORT');
    Route::any('fundaudittrailexcel', [FundManagementReportController::class, 'getAuditTrailExcel'])->name('GET Fund Audit Trail Excel REPORT');
    Route::any('fundnavmovementreport', [FundManagementReportController::class, 'getFundNAVMovementReport'])->name('GET Fund NAV Movement REPORT');
    Route::any('fundaudittrailexcel', [FundManagementReportController::class, 'getAuditTrailExcel'])->name('GET Fund Audit Trail Excel REPORT');
});

Route::group(['tag' => 'Annual Fees Report'], function () {
    Route::any('amsfaumreport', [AnnualFeesReportController::class, 'getAmsfaumReport'])->name('GET AMSF AUM REPORT');
    Route::any('amsfaumexcel', [AnnualFeesReportController::class, 'getAmsfAumExcel'])->name('GET AMSF AUM Excel REPORT');
    Route::any('amsfgrosssalereport', [AnnualFeesReportController::class, 'getAmsfGrossSaleReport'])->name('GET AMSF Gross Sale REPORT');
    Route::any('amsfgrosssaleexcel', [AnnualFeesReportController::class, 'getAmsfGrossSaleExcel'])->name('GET AMSF Gross Sale Excel REPORT');
    Route::any('amsftotalsubmissionreport', [AnnualFeesReportController::class, 'getAmsfTotalSubmissionReport'])->name('GET AMSF Total Submission REPORT');
    Route::any('amsftotalsubmissionexcel', [AnnualFeesReportController::class, 'getAmsfTotalSubmissionExcel'])->name('GET AMSF Total Submission Excel REPORT');
    Route::any('amsfsummaryutmcreport', [AnnualFeesReportController::class, 'getAmsfSummaryUTMCReport'])->name('GET AMSF Summary UTMC REPORT');
    Route::any('amsfsummaryutmcexcel', [AnnualFeesReportController::class, 'getAmsfSummaryUTMCExcel'])->name('GET AMSF Summary UTMC Excel REPORT');
    Route::any('amsfsummaryiutareport', [AnnualFeesReportController::class, 'getAmsfSummaryIUTAReport'])->name('GET AMSF Summary IUTA REPORT');
    Route::any('amsfsummaryiutaexcel', [AnnualFeesReportController::class, 'getAmsfSummaryIUTAExcel'])->name('GET AMSF Summary IUTA Excel REPORT');
    Route::any('amsfsummaryutmcprpreport', [AnnualFeesReportController::class, 'getAmsfSummaryUTMCPRPReport'])->name('GET AMSF Summary UTMC PRP REPORT');
    Route::any('amsfsummaryutmcprpexcel', [AnnualFeesReportController::class, 'getAmsfSummaryUTMCPRPExcel'])->name('GET AMSF Summary UTMC PRP Excel REPORT');
    Route::any('amsfsummaryprpreport', [AnnualFeesReportController::class, 'getAmsfSummaryPRPReport'])->name('GET AMSF Summary  PRP REPORT');
    Route::any('amsfsummaryprpexcel', [AnnualFeesReportController::class, 'getAmsfSummaryPRPExcel'])->name('GET AMSF Summary PRP Excel REPORT');
    Route::any('amsfsummaryiutaiprpreport', [AnnualFeesReportController::class, 'getAmsfSummaryIUTAIPRPReport'])->name('GET AMSF Summary  IUTA IPRP REPORT');
    Route::any('amsfsummaryiutaiprpexcel', [AnnualFeesReportController::class, 'getAmsfSummaryIUTAIPRPExcel'])->name('GET AMSF Summary IUTA IPRP Excel REPORT');
    Route::any('amsfsummaryutmciprpreport', [AnnualFeesReportController::class, 'getAmsfSummaryUTMCIPRPReport'])->name('GET AMSF Summary  UTMC IPRP REPORT');
    Route::any('amsfsummaryutmciprpexcel', [AnnualFeesReportController::class, 'getAmsfSummaryUTMCIPRPExcel'])->name('GET AMSF Summary UTMC IPRP Excel REPORT');
    Route::any('amsfsummarycutacprareport', [AnnualFeesReportController::class, 'getAmsfSummaryCUTACPRAReport'])->name('GET AMSF Summary  CUTA CPRA REPORT');
    Route::any('amsfsummarycutacpraexcel', [AnnualFeesReportController::class, 'getAmsfSummaryCUTACPRAExcel'])->name('GET AMSF Summary CUTA CPRA Excel REPORT');
    Route::any('amsfaumtgsreport', [AnnualFeesReportController::class, 'getAmsfAUMTGSReport'])->name('GET AMSF Summary AUM & TGS REPORT');
    Route::any('amsfaumtgsexcel', [AnnualFeesReportController::class, 'getAmsfAUMTGSExcel'])->name('GET AMSF Summary AUM & TGS Excel REPORT');
    Route::any('amsfa1formdistributorreport', [AnnualFeesReportController::class, 'getAmsfA1FormDistributorReport'])->name('GET AMSF A1 Form Distributor REPORT');
    Route::any('amsfa1formdistributorexcel', [AnnualFeesReportController::class, 'getAmsfA1FormDistributorExcel'])->name('GET AMSF A1 Form Distributor Excel REPORT');
    Route::any('amsfa2formdistributorreport', [AnnualFeesReportController::class, 'getAmsfA2FormDistributorReport'])->name('GET AMSF A2 Form Distributor REPORT');
    Route::any('amsfa2formdistributorexcel', [AnnualFeesReportController::class, 'getAmsfA2FormDistributorExcel'])->name('GET AMSF A2 Form Distributor Excel REPORT');
    Route::any('amsfb1formdistributorreport', [AnnualFeesReportController::class, 'getAmsfB1FormDistributorReport'])->name('GET AMSF B1 Form Distributor REPORT');
    Route::any('amsfb1formdistributorexcel', [AnnualFeesReportController::class, 'getAmsfB1FormDistributorExcel'])->name('GET AMSF B1 Form Distributor Excel REPORT');
    Route::any('amsfb2formdistributorreport', [AnnualFeesReportController::class, 'getAmsfB2FormDistributorReport'])->name('GET AMSF B2 Form Distributor REPORT');
    Route::any('amsfb2formdistributorexcel', [AnnualFeesReportController::class, 'getAmsfB2FormDistributorExcel'])->name('GET AMSF B2 Form Distributor Excel REPORT');
    Route::any('amsfc1formdistributorreport', [AnnualFeesReportController::class, 'getAmsfC1FormDistributorReport'])->name('GET AMSF C1 Form Distributor REPORT');
    Route::any('amsfc1formdistributorexcel', [AnnualFeesReportController::class, 'getAmsfC1FormDistributorExcel'])->name('GET AMSF C1 Form Distributor Excel REPORT');
    Route::any('amsfc2formdistributorreport', [AnnualFeesReportController::class, 'getAmsfC2FormDistributorReport'])->name('GET AMSF C2 Form Distributor REPORT');
    Route::any('amsfc2formdistributorexcel', [AnnualFeesReportController::class, 'getAmsfC2FormDistributorExcel'])->name('GET AMSF C2 Form Distributor Excel REPORT');
    Route::any('amsfd1formdistributorreport', [AnnualFeesReportController::class, 'getAmsfD1FormDistributorReport'])->name('GET AMSF D1 Form Distributor REPORT');
    Route::any('amsfd1formdistributorexcel', [AnnualFeesReportController::class, 'getAmsfD1FormDistributorExcel'])->name('GET AMSF D1 Form Distributor Excel REPORT');
    Route::any('amsfd2formdistributorreport', [AnnualFeesReportController::class, 'getAmsfD2FormDistributorReport'])->name('GET AMSF D2 Form Distributor REPORT');
    Route::any('amsfd2formdistributorexcel', [AnnualFeesReportController::class, 'getAmsfD2FormDistributorExcel'])->name('GET AMSF D2 Form Distributor Excel REPORT');
    Route::any('amsfaumtgsdistributorreport', [AnnualFeesReportController::class, 'getAmsfAUMTGSDistributorReport'])->name('GET AMSF  AUM & TGS External Distributor REPORT');
    Route::any('amsfaumtgsdistributorexcel', [AnnualFeesReportController::class, 'getAmsfAUMTGSDistributorExcel'])->name('GET AMSF AUM & TGS External Distributor Excel REPORT');
    Route::any('amsftotalaumreport', [AnnualFeesReportController::class, 'getAmsfTotalAUMReport'])->name('GET AMSF  Total AUM REPORT');
    Route::any('amsftotalaumexcel', [AnnualFeesReportController::class, 'getAmsfTotalAUMExcel'])->name('GET AMSF Total AUM Excel REPORT');
    Route::any('amsftotalaumreport', [AnnualFeesReportController::class, 'getAmsfTotalSALESReport'])->name('GET AMSF  Total SALES REPORT');
    Route::any('amsftotalsalesexcel', [AnnualFeesReportController::class, 'getAmsfTotalSALESExcel'])->name('GET AMSF Total SALES Excel REPORT');
});

Route::group(['tag' => 'Main Dashboard Setting'], function () {
    Route::get('dashboard_setting_main', [DashboardMainSettingController::class, 'getMainDashboardSetting'])->name('Main Setting LIST');
    Route::post('main_dashboard_setting_create', [DashboardMainDisplaySettingController::class, 'create'])->name('Main Setting Create');
    Route::post('delete_main_dashboard_setting', [DashboardMainDisplaySettingController::class, 'delete'])->name('Main Setting Delete');
    Route::get('get_main_dashboard_setting', [DashboardMainDisplaySettingController::class, 'get'])->name('Get Main Setting');
    Route::get('get_main_chart_setting_cpd_one', [DashboardMainDisplaySettingController::class, 'getCPDChartSettingOne'])->name('Get Main Chart Setting');
    Route::get('get_main_chart_setting_cpd_two', [DashboardMainDisplaySettingController::class, 'getCPDChartSettingTwo'])->name('Get Main Chart Setting Two');
    Route::get('get_main_chart_setting_cpd_three', [DashboardMainDisplaySettingController::class, 'getCPDChartSettingThree'])->name('Get Main Chart Setting Three');
    Route::get('get_main_chart_setting_cpd_four', [DashboardMainDisplaySettingController::class, 'getCPDChartSettingFour'])->name('Get Main Chart Setting Four');
    Route::get('get_main_chart_setting_cpd_five', [DashboardMainDisplaySettingController::class, 'getCPDChartSettingFive'])->name('Get Main Chart Setting Five');
    Route::get('get_main_chart_setting_cpd_six', [DashboardMainDisplaySettingController::class, 'getCPDChartSettingSix'])->name('Get Main Chart Setting Six');
    Route::get('get_main_chart_setting_cpd_seven', [DashboardMainDisplaySettingController::class, 'getCPDChartSettingSeven'])->name('Get Main Chart Setting Seven');
    Route::get('get_main_chart_setting_cpd_eight', [DashboardMainDisplaySettingController::class, 'getCPDChartSettingEight'])->name('Get Main Chart Setting Eight');
    Route::get('get_main_chart_setting_cas_one', [DashboardMainDisplaySettingController::class, 'getCASChartSettingOne'])->name('Get Main Chart Setting CAS ONE');
    Route::get('get_main_chart_setting_cas_two', [DashboardMainDisplaySettingController::class, 'getCASChartSettingTwo'])->name('Get Main Chart Setting CAS Two');
    Route::get('get_main_chart_setting_cas_three', [DashboardMainDisplaySettingController::class, 'getCASChartSettingThree'])->name('Get Main Chart Setting CAS Three');
    Route::get('get_main_chart_setting_cas_four', [DashboardMainDisplaySettingController::class, 'getCASChartSettingFour'])->name('Get Main Chart Setting CAS Four');
    Route::get('get_main_chart_setting_cas_five', [DashboardMainDisplaySettingController::class, 'getCASChartSettingFive'])->name('Get Main Chart Setting CAS Five');
    Route::get('get_main_chart_setting_distributor_one', [DashboardMainDisplaySettingController::class, 'getDISTRIBUTORChartSettingOne'])->name('Get Main Chart Setting Distributor One');
    Route::get('get_main_chart_setting_distributor_two', [DashboardMainDisplaySettingController::class, 'getDISTRIBUTORChartSettingTwo'])->name('Get Main Chart Setting Distributor Two');
    Route::get('get_main_chart_setting_distributor_three', [DashboardMainDisplaySettingController::class, 'getDISTRIBUTORChartSettingThree'])->name('Get Main Chart Setting Distributor Three');
    Route::get('get_main_chart_setting_distributor_four', [DashboardMainDisplaySettingController::class, 'getDISTRIBUTORChartSettingFour'])->name('Get Main Chart Setting Distributor Four');
    Route::get('get_main_chart_setting_distributor_five', [DashboardMainDisplaySettingController::class, 'getDISTRIBUTORChartSettingFive'])->name('Get Main Chart Setting Distributor Five');
    Route::get('get_main_chart_setting_distributor_six', [DashboardMainDisplaySettingController::class, 'getDISTRIBUTORChartSettingSix'])->name('Get Main Chart Setting Distributor Six');
    Route::get('get_main_chart_setting_distributor_seven', [DashboardMainDisplaySettingController::class, 'getDISTRIBUTORChartSettingSeven'])->name('Get Main Chart Setting Distributor Seven');
    Route::get('get_main_chart_setting_distributor_eight', [DashboardMainDisplaySettingController::class, 'getDISTRIBUTORChartSettingEight'])->name('Get Main Chart Setting Distributor Eight');
    Route::get('get_main_chart_setting_distributor_nine', [DashboardMainDisplaySettingController::class, 'getDISTRIBUTORChartSettingNine'])->name('Get Main Chart Setting Distributor Nine');
    Route::get('get_main_chart_setting_distributor_ten', [DashboardMainDisplaySettingController::class, 'getDISTRIBUTORChartSettingTen'])->name('Get Main Chart Setting Distributor Ten');
    Route::get('get_main_chart_setting_distributor_eleven', [DashboardMainDisplaySettingController::class, 'getDISTRIBUTORChartSettingEleven'])->name('Get Main Chart Setting Distributor Eleven');
    Route::get('get_main_chart_setting_distributor_twelve', [DashboardMainDisplaySettingController::class, 'getDISTRIBUTORChartSettingTwelve'])->name('Get Main Chart Setting Distributor Twelve');
    Route::get('get_main_chart_setting_distributor_thirteen', [DashboardMainDisplaySettingController::class, 'getDISTRIBUTORChartSettingThirteen'])->name('Get Main Chart Setting Distributor Thirteen');
    Route::get('get_main_chart_setting_distributor_fourteen', [DashboardMainDisplaySettingController::class, 'getDISTRIBUTORChartSettingFourteen'])->name('Get Main Chart Setting Distributor Fourteen');
    Route::get('get_main_chart_setting_consultant_one', [DashboardMainDisplaySettingController::class, 'getCONSULTANTChartSettingOne'])->name('Get Main Chart Setting Consultant One');
    Route::get('get_main_chart_setting_consultant_two', [DashboardMainDisplaySettingController::class, 'getCONSULTANTChartSettingTwo'])->name('Get Main Chart Setting Consultant Two');
    Route::get('get_main_chart_setting_consultant_three', [DashboardMainDisplaySettingController::class, 'getCONSULTANTChartSettingThree'])->name('Get Main Chart Setting Consultant Three');
    Route::get('get_main_chart_setting_consultant_four', [DashboardMainDisplaySettingController::class, 'getCONSULTANTChartSettingFour'])->name('Get Main Chart Setting Consultant Four');
    Route::get('get_main_chart_setting_consultant_five', [DashboardMainDisplaySettingController::class, 'getCONSULTANTChartSettingFive'])->name('Get Main Chart Setting Consultant Five');
    Route::get('get_main_chart_setting_fms_one', [DashboardMainDisplaySettingController::class, 'getFMSChartSettingOne'])->name('Get Main Chart Setting FMS One');
    Route::get('get_main_chart_setting_fms_two', [DashboardMainDisplaySettingController::class, 'getFMSChartSettingTwo'])->name('Get Main Chart Setting FMS Two');
    Route::get('get_main_chart_setting_fms_three', [DashboardMainDisplaySettingController::class, 'getFMSChartSettingThree'])->name('Get Main Chart Setting FMS Three');
    Route::get('get_main_chart_setting_fms_four', [DashboardMainDisplaySettingController::class, 'getFMSChartSettingFour'])->name('Get Main Chart Setting FMS Four');
    Route::get('get_main_chart_setting_fms_five', [DashboardMainDisplaySettingController::class, 'getFMSChartSettingFive'])->name('Get Main Chart Setting FMS Five');
    Route::get('get_main_chart_setting_fms_six', [DashboardMainDisplaySettingController::class, 'getFMSChartSettingSix'])->name('Get Main Chart Setting FMS Six');
    Route::get('get_main_chart_setting_fms_seven', [DashboardMainDisplaySettingController::class, 'getFMSChartSettingSeven'])->name('Get Main Chart Setting FMS Seven');
    Route::get('get_main_chart_setting_fms_eight', [DashboardMainDisplaySettingController::class, 'getFMSChartSettingEight'])->name('Get Main Chart Setting FMS Eight');
    Route::get('get_main_chart_setting_fms_nine', [DashboardMainDisplaySettingController::class, 'getFMSChartSettingNine'])->name('Get Main Chart Setting FMS Nine');
    Route::get('get_main_chart_setting_finance_one', [DashboardMainDisplaySettingController::class, 'getFINANCEChartSettingOne'])->name('Get Main Chart Setting FINANCE One');
    Route::get('get_main_chart_setting_finance_two', [DashboardMainDisplaySettingController::class, 'getFINANCEChartSettingTwo'])->name('Get Main Chart Setting FINANCE Two');
});

Route::group(['tag' => 'Distributor ID Masking Setting'], function () {
    Route::post('create_distributor_masking', [DistributorIdMaskingController::class, 'create'])->name('Create ID Masking');
    Route::get('distributor_all_masking', [DistributorIdMaskingController::class, 'getAll'])->name('Get all Masking');
    Route::get('distributor_latest_masking', [DistributorIdMaskingController::class, 'getLatest'])->name('Get Latest Masking');
    Route::get('distributor_masking_by_id', [DistributorIdMaskingController::class, 'get'])->name('Get Masking by Id');
    Route::put('distributor_masking_update', [DistributorIdMaskingController::class, 'update'])->name('Update  Masking');
    Route::delete('distributor_masking_delete', [DistributorIdMaskingController::class, 'delete'])->name('Delete Masking');
});
Route::group(['tag' => 'Consultant ID Masking Setting'], function () {
    Route::post('create_consultant_masking', [ConsultantIdMaskingController::class, 'create'])->name('Create ID Masking');
    Route::get('consultant_all_masking', [ConsultantIdMaskingController::class, 'getAll'])->name('Get all Masking');
    Route::get('consultant_latest_masking', [ConsultantIdMaskingController::class, 'getLatest'])->name('Get Latest Masking');
    Route::get('consultant_masking_by_id', [ConsultantIdMaskingController::class, 'get'])->name('Get Masking by Id');
    Route::put('consultant_masking_update', [ConsultantIdMaskingController::class, 'update'])->name('Update  Masking');
    Route::delete('consultant_masking_delete', [ConsultantIdMaskingController::class, 'delete'])->name('Delete Masking');
});
Route::group(['tag' => 'Audit Trail Setting'], function () {
    Route::get('main_module_type', [AuditTrailSettingController::class, 'getAllMainModule'])->name('Get All Module');
    Route::post('get_audit_trail_data', [AuditTrailSettingController::class, 'getAuditTrailData'])->name('Get All Audit Trail');
});
