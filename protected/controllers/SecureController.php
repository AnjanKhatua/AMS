<?php

//*****  @package         Yii          *****//
//*****  @subpackage      Rest Server  *****//
//*****  @category        Controller   *****//
//*****  @author          Md Ibrahim   *****//


class SecureController extends Controller {

    private function sendAjaxResponse($data = array(), $status = '', $message = '') {
        header('Content-type: application/json', true, 200);
        echo json_encode([
            'data' => $data,
            'status' => $status,
            'message' => $message
        ]);
        Yii::app()->end();
    }

    /******************STAFF SECTION********************/
    /***************************************************/

    public function actionLogin() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        $response = Custom::userLogin($request);
        if ($response != 'fail') {
            $this->sendAjaxResponse($response, 'success', '');
        } else
            $this->sendAjaxResponse('', $response, '');
    }

    public function actionGetStaffDetails() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
//        print_r($request);die;
        $response = Custom::getStaffDetails($request);
        if ($response != 'fail') {
            $this->sendAjaxResponse($response, 'success', '');
        } else
            $this->sendAjaxResponse('', $response, '');
    }

    public function actionImageUpload() {
        $target_dir = Yii::app()->basePath . '/../userImage/';
        $target_file = $target_dir . basename($_FILES["file"]["name"]);
        move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
    }

    public function actionUpdateUserImage() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        $response = Custom::changeUserImage($request);
        if ($response) {
            $this->sendAjaxResponse('', 'success', '');
        } else
            $this->sendAjaxResponse('', 'error', '');
    }

    public function actionGetUpcomingAvailableShift() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        $response = Custom::getUpcomingAvailableShifts($request);
        if ($response) {
            $this->sendAjaxResponse($response, 'success', '');
        } else
            $this->sendAjaxResponse('', 'error', '');
    }

    public function actionGetAvailableShiftDetails() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        $response = Custom::getUpcomingAvailableShiftDetails($request);
        if ($response) {
            $this->sendAjaxResponse($response, 'success', '');
        } else
            $this->sendAjaxResponse('', 'error', '');
    }

    public function actionApplyForShift() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        $response = Custom::shiftApply($request);
        if ($response) {
            $this->sendAjaxResponse('', 'success', '');
        } else
            $this->sendAjaxResponse('', 'error', '');
    }

    public function actionCancelShift() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        $response = Custom::shiftCancel($request);
        if ($response) {
            $this->sendAjaxResponse('', 'success', '');
        } else
            $this->sendAjaxResponse('', 'error', '');
    }

    public function actionGetPreBookedShift() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        $response = Custom::getPreBookedShifts($request);
        if ($response) {
            $this->sendAjaxResponse($response, 'success', '');
        } else
            $this->sendAjaxResponse('', 'error', '');
    }

    public function actionGetHistoricalShift() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        $response = Custom::getHistoricalShifts($request);
        if ($response) {
            $this->sendAjaxResponse($response, 'success', '');
        } else
            $this->sendAjaxResponse('', 'error', '');
    }

    public function actionGetCancelConfirmedShift() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        $response = Custom::getCancelConfirmedShifts($request);
        if ($response) {
            $this->sendAjaxResponse($response, 'success', '');
        } else
            $this->sendAjaxResponse('', 'error', '');
    }

    public function actionGetHospitalName() {
        $postdata = file_get_contents("php://input");
        $response = Custom::getHospitalNames($postdata);
        if ($response) {
            $this->sendAjaxResponse($response, 'success', '');
        } else
            $this->sendAjaxResponse('', 'error', '');
    }

    public function actionTimeSheetUpload() {
        $target_dir = Yii::app()->basePath . '/../staffTimesheet/';
        $target_file = $target_dir . basename($_FILES["file"]["name"]);
        move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
    }

    public function actionUploadTimesheetOfStaff() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        $response = Custom::uploadTimesheetOfStaff($request);
        if ($response) {
            $this->sendAjaxResponse('', 'success', '');
        } else
            $this->sendAjaxResponse('', 'error', '');
    }

    public function actionSendEmail() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        $response = Custom::sendEmail($request);
        if ($response) {
            $this->sendAjaxResponse('', 'success', '');
        } else
            $this->sendAjaxResponse('', 'error', '');
    }

    /***************COORDINATOR SECTION*****************/
    /***************************************************/

    public function actionGetCoordinatorDetails() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        $response = Custom::getCoordinatorDetails($request);
        if ($response != 'fail') {
            $this->sendAjaxResponse($response, 'success', '');
        } else
            $this->sendAjaxResponse('', $response, '');
    }

    public function actionGetAllHospitalLists() {
        $response = Custom::getAllHospitalLists();
        if ($response) {
            $this->sendAjaxResponse($response, 'success', '');
        } else
            $this->sendAjaxResponse('', 'error', '');
    }

    public function actionGetAllStaffLists() {
        $response = Custom::getAllStaffLists();
        if ($response) {
            $this->sendAjaxResponse($response, 'success', '');
        } else
            $this->sendAjaxResponse('', 'error', '');
    }

    public function actionSendMailOrSmsTOAllStaff() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        $response = Custom::sendMailOrSmsToAllstaff($request);
    }

    public function actionSendMailOrSms() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        $response = Custom::sendMailOrSms($request);
    }

    public function actionGetDraftStaffLists() {
        $response = Custom::getAllDraftStaffLists();
        if ($response) {
            $this->sendAjaxResponse($response, 'success', '');
        } else
            $this->sendAjaxResponse('', 'error', '');
    }

    public function actionGetInactiveStaffLists() {
        $response = Custom::getAllInactiveStaffLists();
        if ($response) {
            $this->sendAjaxResponse($response, 'success', '');
        } else
            $this->sendAjaxResponse('', 'error', '');
    }

    public function actionGetSuspendedStaffLists() {
        $response = Custom::getAllSuspendedStaffLists();
        if ($response) {
            $this->sendAjaxResponse($response, 'success', '');
        } else
            $this->sendAjaxResponse('', 'error', '');
    }

    public function actionGetArchiveStaffLists() {
        $response = Custom::getAllArchiveStaffLists();
        if ($response) {
            $this->sendAjaxResponse($response, 'success', '');
        } else
            $this->sendAjaxResponse('', 'error', '');
    }

    public function actionGetAllStaffRota() {
        $postdata = file_get_contents("php://input");
//        $request = json_decode($postdata);
//        print_r($postdata);die;
        $response = Custom::getautocompleteNameEmail($postdata);
        if ($response) {
            $this->sendAjaxResponse($response, 'success', '');
        } else
            $this->sendAjaxResponse('', 'error', '');
    }


     /*****************REPORT SECTION*******************/
    /***************************************************/
    
    public function actionGetExpiryReportDetails() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
  
        $response = Custom::getExpiryReportDetails($request);
        if ($response){
            $this->sendAjaxResponse($response, 'success', '');
        } else
            $this->sendAjaxResponse('', 'error', '');
    }

    public function actionGetShiftAllocationReportDetails() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        
        $response = Custom::getShiftAllocationReportDetails($request);
        if ($response){
            $this->sendAjaxResponse($response, 'success', '');
        } else
            $this->sendAjaxResponse('', 'error', '');
    }
    
    public function actionGetStaffAvailabilityDetails() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        
        $response = Custom::getStaffAvailabilityDetails($request);
        if ($response){
            $this->sendAjaxResponse($response, 'success', '');
        } else
            $this->sendAjaxResponse('', 'error', '');
    }
    
    public function actionGetStaffCancelDetails() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        
        $response = Custom::getStaffCancelDetails($request);
        if ($response){
            $this->sendAjaxResponse($response, 'success', '');
        } else
            $this->sendAjaxResponse('', 'error', '');
    }
    
    public function actionGetNotAllocatedStaffDetails() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        
        $response = Custom::getNotAllocatedStaffDetails($request);
        if ($response){
            $this->sendAjaxResponse($response, 'success', '');
        } else
            $this->sendAjaxResponse('', 'error', '');
    }
    
     public function actionGetRotaReportDetails() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        
        $response = Custom::getRotaReportDetails($request);
        if ($response){
            $this->sendAjaxResponse($response, 'success', '');
        } else
            $this->sendAjaxResponse('', 'error', '');
    }
    
    public function actionGetHospitalServiceInfoDetails() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        
        $response = Custom::getHospitalServiceInfoDetails($request);
        if ($response){
            $this->sendAjaxResponse($response, 'success', '');
        } else
            $this->sendAjaxResponse('', 'error', '');
    }
    
    public function actionGetStaffRotaReportDetails() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        
        $response = Custom::getStaffRotaReportDetails($request);
        if ($response){
            $this->sendAjaxResponse($response, 'success', '');
        } else
            $this->sendAjaxResponse('', 'error', '');
    }
          
    public function actionGetAllStaffList() {
        $response = Custom::getAllStaffList($request);
        if ($response){
            $this->sendAjaxResponse($response, 'success', '');
        } else
            $this->sendAjaxResponse('', 'error', '');
    }
    
    public function actionGetAllHospitalNameList() {
        $response = Custom::getAllHospitalLists($request);
        if ($response){
            $this->sendAjaxResponse($response, 'success', '');
        } else
            $this->sendAjaxResponse('', 'error', '');
    }
    
    public function actionGetStaffRotaDetails() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        $response = Custom::getRotaDetailsOfStaffs($request);
        if ($response == 'no data') {
            $ls_resultReturnEmpty = $request->staffInfo . " has not been allocated any shift for next 30 days!";
            $this->sendAjaxResponse('no data', '', '');
        } else
            $this->sendAjaxResponse($response, 'success', '');
    }

    public function actionGetAllHospitalUnitNames() {
        $response = Custom::getAllHospitalUnitNames();
        if ($response) {
            $this->sendAjaxResponse($response, 'success', '');
        } else
            $this->sendAjaxResponse('', 'error', '');
    }

    public function actionGetAlljobTypes() {
        $response = Custom::getAlljobTypes();
        if ($response) {
            $this->sendAjaxResponse($response, 'success', '');
        } else
            $this->sendAjaxResponse('', 'error', '');
    }

    public function actionGetHospitalWards() {
        $postdata = file_get_contents("php://input");
        $response = Custom::getHospitalWards($postdata);
        if ($response) {
            $this->sendAjaxResponse($response, 'success', '');
        } else
            $this->sendAjaxResponse('', 'error', '');
    }

    public function actionCreateShiftForHospitals() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        $response = Custom::createShiftForHospitals($request);
        if ($response != 'fail') {
            $this->sendAjaxResponse('', 'success', '');
        } else
            $this->sendAjaxResponse('', $response, '');
    }

    public function actionGetAllShiftLists() {
        $response = Custom::getAllShiftLists();
        if ($response != 'no data') {
            $this->sendAjaxResponse($response, 'success', '');
        } else
            $this->sendAjaxResponse('', 'error', '');
    }

    public function actionGetShiftDetailsForHospital() {
        $postdata = file_get_contents("php://input");
        $response = Custom::getShiftDetailsForHospital($postdata);
        if ($response) {
            $this->sendAjaxResponse($response, 'success', '');
        } else
            $this->sendAjaxResponse('', 'error', '');
    }

    public function actionDeleteShift() {
        $postdata = file_get_contents("php://input");
        $response = Custom::deleteShift($postdata);
        if ($response) {
            $this->sendAjaxResponse('', 'success', '');
        } else
            $this->sendAjaxResponse('', 'error', '');
    }

    public function actionUpdateShiftForHospitals() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        $response = Custom::updateShiftForHospitals($request);
        if ($response != 'fail') {
            $this->sendAjaxResponse('', 'success', '');
        } else
            $this->sendAjaxResponse('', $response, '');
    }

    public function actionGetAllShiftListsCreatedByYou() {
        $postdata = file_get_contents("php://input");
        $response = Custom::getAllShiftListsCreatedByYou($postdata);
        if ($response != 'no data') {
            $this->sendAjaxResponse($response, 'success', '');
        } else
            $this->sendAjaxResponse('', 'error', '');
    }

    public function actionGetStaffsWhomEnquiryNotSend() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        $response = Custom::getStaffsWhomEnquiryNotSend($request);
        if ($response != 'no data') {
            $this->sendAjaxResponse($response, 'success', '');
        } else
            $this->sendAjaxResponse($response, 'error', '');
    }

    public function actionSendEnquiry() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        $response = Custom::sendEnquiry($request);
        if ($response) {
            $this->sendAjaxResponse('', 'success', '');
        } else
            $this->sendAjaxResponse('', 'error', '');
    }

    public function actionDirectConfirmAvailability() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        $response = Custom::directConfirmAvailability($request);
        if ($response) {
            $this->sendAjaxResponse('', 'success', '');
        } else
            $this->sendAjaxResponse('', 'error', '');
    }

    public function actionDirectConfirmBooking() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        $response = Custom::directConfirmBooking($request);
        if ($response == 'fulfilled') {
            $this->sendAjaxResponse('', 'fulfilled', '');
        } else if ($response == 'success') {
            $this->sendAjaxResponse('', 'success', '');
        } else
            $this->sendAjaxResponse('', 'error', '');
    }

    public function actionGetStaffsWhomEnquirySendNotConfirmed() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        $response = Custom::getStaffsWhomEnquirySendNotConfirmed($request);
        if ($response != 'no data') {
            $this->sendAjaxResponse($response, 'success', '');
        } else
            $this->sendAjaxResponse($response, 'error', '');
    }

    public function actionConfirmShift() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        $response = Custom::confirmShift($request);
        if ($response) {
            $this->sendAjaxResponse('', 'success', '');
        } else
            $this->sendAjaxResponse('', 'error', '');
    }

    public function actionGetStaffsWhoConfirmedTheirAvailability() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        $response = Custom::getStaffsWhoConfirmedTheirAvailability($request);
        if ($response != 'no data') {
            $this->sendAjaxResponse($response, 'success', '');
        } else
            $this->sendAjaxResponse($response, 'error', '');
    }

    public function actionAllocateShift() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        $response = Custom::allocateShift($request);
        if ($response == 'fulfilled') {
            $this->sendAjaxResponse('', 'fulfilled', '');
        } else if ($response == 'success') {
            $this->sendAjaxResponse('', 'success', '');
        } else
            $this->sendAjaxResponse('', 'error', '');
    }

    public function actionGetStaffsBookedForThisShift() {
        $postdata = file_get_contents("php://input");
//        $request = json_decode($postdata);
        $response = Custom::getStaffsBookedForThisShift($postdata);
        if ($response != 'no data') {
            $this->sendAjaxResponse($response, 'success', '');
        } else
            $this->sendAjaxResponse($response, 'error', '');
    }

    public function actionSendSms() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        $response = Custom::sendSms($request);
        if ($response) {
            $this->sendAjaxResponse('', 'success', '');
        } else
            $this->sendAjaxResponse('', 'error', '');
    }

    public function actionRejection() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        $response = Custom::rejection($request);
        if ($response) {
            $this->sendAjaxResponse('', 'success', '');
        } else
            $this->sendAjaxResponse('', 'error', '');
    }

    public function actionGetCancelAfterBookedStaffList() {
        $postdata = file_get_contents("php://input");
//        $request = json_decode($postdata);
        $response = Custom::getCancelAfterBookedStaffList($postdata);
        if ($response != 'no data') {
            $this->sendAjaxResponse($response, 'success', '');
        } else
            $this->sendAjaxResponse($response, 'error', '');
    }

    public function actionAllocateShiftAgain() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        $response = Custom::allocateShiftAgain($request);
        if ($response == 'fulfilled') {
            $this->sendAjaxResponse('', 'fulfilled', '');
        } else if ($response == 'assigned') {
            $this->sendAjaxResponse('', 'assigned', '');
        } else if ($response == 'success') {
            $this->sendAjaxResponse('', 'success', '');
        } else
            $this->sendAjaxResponse('', 'error', '');
    }
    
    public function actionGetAllUnfilledShiftLists() {
        $response = Custom::getAllUnfilledShiftLists();
        if ($response != 'no data') {
            $this->sendAjaxResponse($response, 'success', '');
        } else
            $this->sendAjaxResponse('', 'error', '');
    }
    
    public function actionGetAllArchiveShiftLists() {
        $response = Custom::getAllArchiveShiftLists();
        if ($response != 'no data') {
            $this->sendAjaxResponse($response, 'success', '');
        } else
            $this->sendAjaxResponse('', 'error', '');
    }
    
    public function actionGetAllHistoricalFilledShiftLists() {
        $response = Custom::getAllHistoricalFilledShiftLists();
        if ($response != 'no data') {
            $this->sendAjaxResponse($response, 'success', '');
        } else
            $this->sendAjaxResponse('', 'error', '');
    }

}

?>
