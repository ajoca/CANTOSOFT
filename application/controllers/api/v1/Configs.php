<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require(APPPATH.'/libraries/REST_Controller.php');
/**  
 * @OA\Info(title="iRestora PLUS Waiter App API Documentation", version="7.5", description="iRestora PLUS - Next Gen Restaurant POS")
 */
class Configs extends REST_Controller
{   
    public function __construct() {
        parent::__construct(); 
    } 
/**
 * @OA\Post(
 *     path="/api/v1/Auth/token",
 *     summary="Generate Token for access API",
 *     tags={"Token"},
 *     @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="client-id",
 *         example="doorsoft",
 *         in="header",
 *         required=true),
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="client-secret",
 *         in="header",
 *         example="doorsoftxyz",
 *         required=true),
 *     @OA\RequestBody(
 *        description="
 *          =================== 
 *          if client-id and client-secret then system will allow to provide the token here, also you will get both keys in the site setting of the software. 
 *          ===================",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
  public function token_get(){}
  /**
 * @OA\Post(
 *     path="/api/v1/TokenActivity/update_token_activity",
 *     summary="Update Token Time",
 *     tags={"Token"},
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Access-Token",
 *         in="header",
 *         required=true),
 *      @OA\RequestBody(
 *        description="
 *          =================== 
 *          System will update the token time
 *          ===================",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
public function update_token_activity_post() {}
  /**
 * @OA\Post(
 *     path="/api/v1/TokenActivity/delete_token",
 *     summary="Delete Token",
 *     tags={"Token"},
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Access-Token",
 *         in="header",
 *         required=true),
 *      @OA\RequestBody(
 *        description="
 *          =================== 
 *          System will delte the token after logout or any other's needed.
 *          ===================",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
public function delete_token_post() {}
/**
 * @OA\POST(
 *     path="/api/v1/Common/outlets",
 *     summary="Get Outlets",
 *     tags={"Panel - Common"},
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Access-Token",
 *         in="header",
 *         required=true),
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Checksum",
 *         in="header",
 *         required=true),
 *     @OA\RequestBody(
 *         required=true,
 *        description="
 *          =================== 
 *          for getting outlet list
 *          ===================",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 example={
 *                     "company_id": "1",
 *                 }
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
public function outlets_get(){}
  /**
 * @OA\Get(
 *     path="/api/v1/Common/users",
 *     summary="Get Users",
 *     tags={"Common"},
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Access-Token",
 *         in="header",
 *         required=true),
 *      @OA\RequestBody(
 *        description="
 *          =================== 
 *          for getting user list
 *          ===================",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 
 *             )
 *         )
 *     ),
 *    @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
public function users_common_get(){}
 
  /**
 * @OA\Get(
 *     path="/api/v1/Common/payment_methods",
 *     summary="Get Users",
 *     tags={"Common"},
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Access-Token",
 *         in="header",
 *         required=true),
 *      @OA\RequestBody(
 *        description="
 *          =================== 
 *          for getting payment method list
 *          ===================",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 
 *             )
 *         )
 *     ),
 *    @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
public function payment_methods_get(){} 
/**
 * @OA\Post(
 *     path="/api/v1/Auth/login",
 *     summary="Login using email and password",
 *     tags={"Authentication"},
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Access-Token",
 *         in="header",
 *         required=true),
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Checksum",
 *         in="header",
 *         required=true),
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Checksum",
 *         in="header",
 *         required=true),
 *     @OA\RequestBody(
 *         required=true,
 *        description="
 *          =================== 
 *          After provide the email and password system will provide the object response if everyting is success, otherwise it will proivde error with message 
 *          ===================",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 example={
 *                     "email": "",
 *                     "password": "",
 *                 }
 *             )
 *         )
 *     ),

 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
  public function login_post(){}

/**
 * @OA\Post(
 *     path="/api/v1/Auth/login_pin",
 *     summary="Login using pin",
 *     tags={"Authentication"},
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Access-Token",
 *         in="header",
 *         required=true),
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Checksum",
 *         in="header",
 *         required=true),
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Checksum",
 *         in="header",
 *         required=true),
 *     @OA\RequestBody(
 *         required=true,
 *        description="
 *          =================== 
 *          After provide the login_pin system will provide the object response if everyting is success, otherwise it will proivde error with message 
 *          ===================",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 example={
 *                     "login_pin": "",
 *                 }
 *             )
 *         )
 *     ),

 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
public function login_pin_post(){}

/**
 * @OA\Post(
 *     path="/api/v1/Auth/is_open_register",
 *     summary="Check register is open or not",
 *     tags={"Authentication"},
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Access-Token",
 *         in="header",
 *         required=true),
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Checksum",
 *         in="header",
 *         required=true),
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Checksum",
 *         in="header",
 *         required=true),
 *     @OA\RequestBody(
 *         required=true,
 *        description="
 *          =================== 
 *          After provide the outlet_id and user_id system will provide the object response if everyting is success, otherwise it will proivde error with message 
 *          ===================",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 example={
 *                     "outlet_id": "1",
 *                     "user_id": "1",
 *                 }
 *             )
 *         )
 *     ),

 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
public function is_open_register_post(){}

/**
 * @OA\Post(
 *     path="/api/v1/Auth/add_register_details",
 *     summary="Add register details",
 *     tags={"Authentication"},
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Access-Token",
 *         in="header",
 *         required=true),
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Checksum",
 *         in="header",
 *         required=true),
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Checksum",
 *         in="header",
 *         required=true),
 *     @OA\RequestBody(
 *         required=true,
 *        description="
 *          =================== 
 *          After provide the company_id system will provide the object response if everyting is success, otherwise it will proivde error with message 
 *          ===================",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 example={
 *                     "company_id": "1",
 *                 }
 *             )
 *         )
 *     ),

 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
public function add_register_details_post(){}
/**
 * @OA\Post(
 *     path="/api/v1/Auth/store_register_details",
 *     summary="Store register details",
 *     tags={"Authentication"},
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Access-Token",
 *         in="header",
 *         required=true),
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Checksum",
 *         in="header",
 *         required=true),
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Checksum",
 *         in="header",
 *         required=true),
 *     @OA\RequestBody(
 *         required=true,
 *        description="
 *          =================== 
 *          After provide the opening_balance, counter_id, user_id, outlet_id, company_id, payment_object system will provide the object response if everyting is success, otherwise it will proivde error with message 
 *          ===================",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 example={
 *                     "opening_balance": "2000",
 *                     "counter_id": "1",
 *                     "user_id": "1",
 *                     "outlet_id": "1",
 *                     "company_id": "1",
 *                     "payment_object": "[{'payment_id':'1','payment_name':'Cash','amount':'10000'},{'payment_id':'2','payment_name':'Card','amount':'10000'}]",
 *                 }
 *             )
 *         )
 *     ),

 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
public function store_register_details_post(){}

/**
 * @OA\Post(
 *     path="/api/v1/Auth/get_register_details",
 *     summary="Get register details",
 *     tags={"Authentication"},
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Access-Token",
 *         in="header",
 *         required=true),
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Checksum",
 *         in="header",
 *         required=true),
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Checksum",
 *         in="header",
 *         required=true),
 *     @OA\RequestBody(
 *         required=true,
 *        description="
 *          =================== 
 *          After provide the counter_id, outlet_id system will provide the object response if everyting is success, otherwise it will proivde error with message 
 *          ===================",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 example={
 *                     "counter_id": "1",
 *                     "outlet_id": "1",
 *                 }
 *             )
 *         )
 *     ),

 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
public function get_register_details_post(){}

/**
 * @OA\Post(
 *     path="/api/v1/Auth/close_register",
 *     summary="Close Register",
 *     tags={"Authentication"},
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Access-Token",
 *         in="header",
 *         required=true),
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Checksum",
 *         in="header",
 *         required=true),
 *     @OA\RequestBody(
 *         required=true,
 *        description="
 *          =================== 
 *          After provide the outlet_id and user_id system will provide the object response if everyting is success, otherwise it will proivde error with message 
 *          ===================",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 example={
 *                     "outlet_id": "1",
 *                     "user_id": "1",  
 *                     "counter_id": "1",
 *                     "company_id": "1",
 *                 }
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
public function close_register_post() {}
/**
 * @OA\Post(
 *     path="/api/v1/Auth/forgot_password_step_one",
 *     summary="Forgot password step one",
 *     tags={"Authentication"},
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Access-Token",
 *         in="header",
 *         required=true),
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Checksum",
 *         in="header",
 *         required=true),
 *     @OA\RequestBody(
 *         required=true,
 *        description="
 *          =================== 
 *          Provide email address for forgot password, if this is valid then system will go to next step
 *          ===================",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 @OA\Property(
 *                     property="email",
 *                     type="string",
*                     example="",
 *                     description="Email"
 *                 ),
 *                 required={"email"}
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
  public function forgot_password_step_one_post() {}

  /**
 * @OA\Post(
 *     path="/api/v1/Auth/forgot_password_step_two",
 *     summary="Forgot password step two",
 *     tags={"Authentication"},
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Access-Token",
 *         in="header",
 *         required=true),
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Checksum",
 *         in="header",
 *         required=true),
 *     @OA\RequestBody(
 *         required=true,
 *         description="<b>Question should be - </b><br>What is your favorite food?<br>What is your mother's maiden name?<br>What is the name of your first pet?<br>What is the name of the town you were born?<br>What primary school did you attend?<br>What Is your favorite book<br> What was the first company that you worked for?<br>What is your favorite food?<br>Where did you meet your spouse?<br>Where is your favorite place to vacation?<br>What is the name of the road you grew up on?",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 @OA\Property(
 *                     property="email",
 *                     type="string",
*                     example="",
 *                     description="Email"
 *                 ),
 *                  @OA\Property(
 *                     property="question",
 *                     type="string",
*                     example="",
 *                     description="Question"
 *                 ),
 *                  @OA\Property(
 *                     property="answer",
 *                     type="string",
*                     example="",
 *                     description="Answer"
 *                 ),
 *                 required={"email","answer","question"}
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
  public function forgot_password_step_two_post() {}
   /**
 * @OA\Post(
 *     path="/api/v1/Auth/forgot_password_step_final",
 *     summary="Forgot password step two",
 *     tags={"Authentication"},
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Access-Token",
 *         in="header",
 *         required=true),
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Checksum",
 *         in="header",
 *         required=true),
 *     @OA\RequestBody(
 *         required=true,
 *        description="
 *          =================== 
 *          put the email, password and confirm password, if everything is valid then system will changed the password
 *          ===================",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                  @OA\Property(
 *                     property="email",
 *                     type="string",
*                     example="",
 *                     description="Email"
 *                 ),
 *                 @OA\Property(
 *                     property="password",
 *                     type="string",
*                     example="",
 *                     description="Password"
 *                 ),
 *                  @OA\Property(
 *                     property="confirm_password",
 *                     type="string",
*                     example="",
 *                     description="Confirm Password"
 *                 ),
 *                 required={"email","password","confirm_password"}
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
  public function forgot_password_step_final_post() {}

/**
 * @OA\post(
 *     path="/api/v1/Auth/change_profile",
 *     summary="Get data change profile",
 *     tags={"Authentication"},
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Access-Token",
 *         in="header",
 *         required=true),
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Checksum",
 *         in="header",
 *         required=true),
 *     @OA\RequestBody(
 *         required=true,
 *        description="
 *          =================== 
 *          Provide email address then system will provide the profile data object here
 *          ===================",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 @OA\Property(
 *                     property="email",
 *                     type="string",
*                     example="",
 *                     description="Eamil Address"
 *                 ),
 *                 required={"email"}
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
  public function change_profile_post() {}
/**
 * @OA\post(
 *     path="/api/v1/Auth/store_change_profile",
 *     summary="store change profile",
 *     tags={"Authentication"},
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Access-Token",
 *         in="header",
 *         required=true),
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Checksum",
 *         in="header",
 *         required=true),
 *     @OA\RequestBody(
 *         required=true,
  *        description="
 *          =================== 
 *          system will updated the all information if required fields data provided there.
 *          ===================",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 @OA\Property(
 *                     property="email_address",
 *                     type="string",
*                     example="",
 *                     description="Email Address"
 *                 ),
 *                  @OA\Property(
 *                     property="full_name",
 *                     type="string",
*                     example="",
 *                     description="Fullname"
 *                 ),
 *                  @OA\Property(
 *                     property="phone",
 *                     type="string",
*                     example="",
 *                     description="phone"
 *                 ),
 *                 required={"email_address","full_name","email_address"}
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
  public function store_change_profile_post() {}
 
/**
 * @OA\post(
 *     path="/api/v1/Auth/store_security_question",
*     summary="Store Security Question",
 *     tags={"Authentication"},
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Access-Token",
 *         in="header",
 *         required=true),
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Checksum",
 *         in="header",
 *         required=true),
 *     @OA\RequestBody(
 *         required=true,
 *         description="<b>Question should be - </b><br>What is your favorite food?<br>What is your mother's maiden name?<br>What is the name of your first pet?<br>What is the name of the town you were born?<br>What primary school did you attend?<br>What Is your favorite book<br> What was the first company that you worked for?<br>What is your favorite food?<br>Where did you meet your spouse?<br>Where is your favorite place to vacation?<br>What is the name of the road you grew up on?",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 @OA\Property(
 *                     property="email_address",
 *                     type="string",
*                     example="",
 *                     description="Email Address"
 *                 ),
 *                  @OA\Property(
 *                     property="question",
 *                     type="string",
*                     example="",
 *                     description="Question"
 *                 ),
 *                  @OA\Property(
 *                     property="answer",
 *                     type="string",
*                     example="",
 *                     description="Answer"
 *                 ),
 *                 required={"email_address","question","answer"}
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
  public function store_security_question_post() {} 
  
/**
 * @OA\Post(
 *     path="/api/v1/Notification/get_notifications",
 *     summary="Get Notifications",
 *     tags={"Notification"},
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Access-Token",
 *         in="header",
 *         required=true),
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Checksum",
 *         in="header",
 *         required=true),
 *     @OA\RequestBody(
 *         required=true,
 *         description="After provide the outlet_id and user_id system will provide the object response if everyting is success, otherwise it will proivde error with message",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 example={
 *                     "outlet_id": "1",
 *                     "user_id": "1",
 *                 }
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
public function get_notifications_post() {}

/**
 * @OA\Post(
 *     path="/api/v1/Notification/remove_notification",
 *     summary="Remove Notification",
 *     tags={"Notification"},
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Access-Token",
 *         in="header",
 *         required=true),
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Checksum",
 *         in="header",
 *         required=true),
 *     @OA\RequestBody(
 *         required=true,
 *         description="After provide the id system will provide the object response if everyting is success, otherwise it will proivde error with message, eg: 1,2,3 it will removed as multiple",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 example={
 *                     "id": "1,2,3",
 *                 }
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
public function remove_notification_post() {}
  
/**
 * @OA\Post(
 *     path="/api/v1/Cart/add_cart_product",
 *     summary="Add/Edit Cart Product",
 *     tags={"Panel - Cart"},
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Access-Token",
 *         in="header",
 *         required=true),
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Checksum",
 *         in="header",
 *         required=true),
 *     @OA\RequestBody(
 *         required=true,
 *         description="Super admin will get the order from api",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 example={
 *                     "user_id": "1",
 *                     "outlet_id": "1",
 *                     "company_id": "1",
 *                     "unique_id": "", 
 *                     "food_menu_id": "129",
 *                     "quantity": "3",
 *                     "order_type": 3,
 *                     "pratner_id": 4,
 *                     "modifier_ids": "[5,6]",
 *                     "discount_type": "1",
 *                     "discount": "10",
 *                     "note": "Updated note"
 *                 }
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
public function add_cart_product_post() {}
 
/**
 * @OA\Post(
 *     path="/api/v1/Cart/remove_cart_product",
 *     summary="Remove Cart Product",
 *     tags={"Panel - Cart"},
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Access-Token",
 *         in="header",
 *         required=true),
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Checksum",
 *         in="header",
 *         required=true),
 *     @OA\RequestBody(
 *         required=true,
 *         description="
 *          =================== 
 *          system will remove the product from cart if required fields data provided there.
 *          ===================",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 example={
 *                     "user_id": "1",
 *                     "outlet_id": "1",
 *                     "company_id": "1",
 *                     "unique_id": "37a16a69-c080-4650-b0ae-d01e6cf82f08", 
 *                 }
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
public function remove_cart_product_post() {}
/**
 * @OA\Post(
 *     path="/api/v1/Cart/cart_details",
 *     summary="Cart Details",
 *     tags={"Panel - Cart"},
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Access-Token",
 *         in="header",
 *         required=true),
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Checksum",
 *         in="header",
 *         required=true),
 *     @OA\RequestBody(
 *         required=true,
 *         description="
 *          =================== 
 *          system will provide the cart details if required fields data provided there.
 *          ===================",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 example={
 *                     "user_id": "1",
 *                     "outlet_id": "1",
 *                     "company_id": "1"
 *                 }
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
public function cart_details_post() {}

/**
 * @OA\Post(
 *     path="/api/v1/Cart/cart_clear",
  *     summary="Clear Cart",
 *     tags={"Panel - Cart"},
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Access-Token",
 *         in="header",
 *         required=true),
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Checksum",
 *         in="header",
 *         required=true),
 *     @OA\RequestBody(
 *         required=true,
 *         description="
 *          =================== 
 *          system will clear the cart if required fields data provided there.
 *          ===================",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 example={
 *                     "user_id": "1",
 *                     "outlet_id": "1",
 *                     "company_id": "1",
 *                 }
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
public function cart_clear_post() {}
/**
 * @OA\Post(
 *     path="/api/v1/Cart/place_order",
 *     summary="Place Order",
 *     tags={"Panel - Cart"},
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Access-Token",
 *         in="header",
 *         required=true),
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Checksum",
 *         in="header",
 *         required=true),
 *     @OA\RequestBody(
 *         required=true,
 *         description="
 *          =================== 
 *          system will place the order if required fields data provided there. charge type will be service or delivery
 *          ===================",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 example={
 *                     "user_id": "1",
 *                     "outlet_id": "1",
 *                     "company_id": "1",
 *                     "customer_id": "1",
 *                     "waiter_id": "1",
 *                     "partner_id": "1",
 *                     "sale_date": "2025-07-03",
 *                     "order_table_no": "B2",
 *                     "tips": "10",
 *                     "charge": "10%",
 *                     "charge_type": "service",
 *                     "discount": "10", 
 *                 }
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
public function place_order_post() {}
 
/**
* @OA\Post(
*     path="/api/v1/Cart/running_orders",
*     summary="Get Orders",
*     tags={"Panel - Cart"},
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Access-Token",
 *         in="header",
 *         required=true),
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Checksum",
 *         in="header",
 *         required=true),
 *     @OA\RequestBody(
*         required=true,
*         description="
*          =================== 
*          system will provide the orders if required fields data provided there.
*          ===================",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 example={
 *                     "user_id": "1",
 *                     "outlet_id": "1",
 *                     "company_id": "1",
 *                 }
 *             )
 *         )
 *     ),
*     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
* )
*/
public function running_orders_post(){}
/**
 * @OA\Post(
 *     path="/api/v1/Cart/generate_invoice",
 *     summary="Generate Invoice",
 *     tags={"Panel - Cart"},
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Access-Token",
 *         in="header",
 *         required=true),
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Checksum",
 *         in="header",
 *         required=true),
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Checksum",
 *         in="header",
 *         required=true),
 *     @OA\RequestBody(
 *         required=true,
 *        description="
 *          =================== 
 *          After provide the order_no, paid_amount, due_amount, given_amount, change_amount, is_multi_currency, multi_currency, multi_currency_rate, multi_currency_amount, payment_object system will provide the object response if everyting is success, otherwise it will proivde error with message 
 *          ===================",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 example={
 *                     "order_no": "rNA250812-007",
 *                     "paid_amount": "10500",
 *                     "due_amount": "0",
 *                     "given_amount": "500",
 *                     "change_amount": "0",
 *                     "is_multi_currency": "",
 *                     "multi_currency": "",
 *                     "multi_currency_rate": "",
 *                     "multi_currency_amount": "",
 *                     "payment_object": "[{'payment_id':'1','payment_name':'Cash','usage_point':'0','amount':'500'},{'payment_id':'2','payment_name':'Card','usage_point':'0','amount':'10000'}]", 
 *                 }
 *             )
 *         )
 *     ),

 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
public function generate_invoice_post(){}

/**
* @OA\Post(
*     path="/api/v1/Cart/get_order_details",
*     summary="Get Order Details",
*     tags={"Panel - Cart"},
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Access-Token",
 *         in="header",
 *         required=true),
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Checksum",
 *         in="header",
 *         required=true),
 *     @OA\RequestBody(
*         required=true,
*         description="
*          =================== 
*          system will provide the order details if required fields data provided there.
*          ===================",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 example={
 *                     "sale_id": "1"
 *                 }
 *             )
 *         )
 *     ),
*     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
* )
*/
public function get_order_details_post(){}
/**
* @OA\Post(
*     path="/api/v1/Cart/get_areas",
*     summary="Get Areas",
*     tags={"Panel - Cart"},
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Access-Token",
 *         in="header",
 *         required=true),
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Checksum",
 *         in="header",
 *         required=true),
 *     @OA\RequestBody(
*         required=true,
*         description="
*          =================== 
*          system will provide the areas if required fields data provided there. 
*          ===================",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 example={
 *                     "outlet_id": "1"
 *                 }
 *             )
 *         )
 *     ),
*     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
* )
*/
public function get_areas_post(){}
/**
* @OA\Post(
*     path="/api/v1/Cart/get_tables",
*     summary="Get Tables",
*     tags={"Panel - Cart"},
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Access-Token",
 *         in="header",
 *         required=true),
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Checksum",
 *         in="header",
 *         required=true),
 *     @OA\RequestBody(
*         required=true,
*         description="
*          =================== 
*          system will provide the tables if required fields data provided there. 
*          ===================",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 example={
 *                     "outlet_id": "1",
 *                     "area_id": "1"
 *                 }
 *             )
 *         )
 *     ),
*     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
* )
*/
public function get_tables_post(){}

/**
 * @OA\Post(
 *     path="/api/v1/Cart/place_hold_order",
 *     summary="Place Hold Order",
 *     tags={"Panel - Hold Order"},
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Access-Token",
 *         in="header",
 *         required=true),
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Checksum",
 *         in="header",
 *         required=true),
 *     @OA\RequestBody(
 *         required=true,
 *         description="
 *          =================== 
 *          system will place the hold order if required fields data provided there. charge type will be service or delivery
 *          ===================",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 example={
 *                     "user_id": "1",
 *                     "outlet_id": "1",
 *                     "company_id": "1",
 *                     "customer_id": "1",
 *                     "waiter_id": "1",
 *                     "partner_id": "1",
 *                     "sale_date": "2025-07-03",
 *                     "order_table_no": "B2",
 *                     "tips": "10",
 *                     "charge": "10%",
 *                     "charge_type": "service",
 *                     "discount": "10", 
 *                 }
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
public function place_hold_order_post() {}

/**
 * @OA\Post(
 *     path="/api/v1/Cart/get_draft_orders",
 *     summary="Get Hold Orders",
 *     tags={"Panel - Hold Order"},
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Access-Token",
 *         in="header",
 *         required=true),
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Checksum",
 *         in="header",
 *         required=true),
 *     @OA\RequestBody(
 *         required=true,
 *         description="
 *          =================== 
 *          system will provide the hold orders if required fields data provided there.
 *          ===================",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 example={
 *                     "outlet_id": "1",
 *                     "user_id": "1"
 *                 }
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
public function get_draft_orders_post() {}


/**
 * @OA\Post(
 *     path="/api/v1/Cart/delete_draft_sale",
 *     summary="Delete Hold Order",
 *     tags={"Panel - Hold Order"},
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Access-Token",
 *         in="header",
 *         required=true),
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Checksum",
 *         in="header",
 *         required=true),
 *     @OA\RequestBody(
 *         required=true,
 *         description="
 *          =================== 
 *          system will delete the hold order if required fields data provided there.
 *          ===================",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 example={
 *                     "id": "1"
 *                 }
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
public function delete_draft_sale_post() {}

  /**
 * @OA\Post(
 *     path="/api/v1/Sale/get_food_menu_categories",
 *     summary="get food menu categories",
 *     tags={"Panel - Common"},
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Access-Token",
 *         in="header",
 *         required=true),
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Checksum",
 *         in="header",
 *         required=true),
 *     @OA\RequestBody(
 *         required=true,
 *        description="
 *          =================== 
 *          After provide the email and password system will provide the object response if everyting is success, otherwise it will proivde error with message 
 *          ===================",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 example={
 *                     "company_id": "1",
 *                 }
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
public function get_food_menu_categories_post() {}  
  /**
 * @OA\Post(
 *     path="/api/v1/Sale/get_food_menus",
 *     summary="get food menus",
 *     tags={"Panel - Common"},
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Access-Token",
 *         in="header",
 *         required=true),
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Checksum",
 *         in="header",
 *         required=true),
 *     @OA\RequestBody(
 *         required=true,
 *        description="
 *          =================== 
 *          After provide the email and password system will provide the object response if everyting is success, otherwise it will proivde error with message 
 *          ===================",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 example={
 *                     "company_id": "1",
 *                     "outlet_id": "1"
 *                 }
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
public function get_food_menus_post() {}  
/**
 * @OA\Post(
 *     path="/api/v1/Sale/get_food_menu_details",
 *     summary="Get Food Menu Details",
 *     tags={"Panel - Common"},
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Access-Token",
 *         in="header",
 *         required=true),
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Checksum",
 *         in="header",
 *         required=true),
 *     @OA\RequestBody(
 *         required=true,
 *        description="
 *          =================== 
 *          After provide the email and password system will provide the object response if everyting is success, otherwise it will proivde error with message 
 *          ===================",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 @OA\Property(
 *                     property="food_menu_id",
 *                     type="string",
*                     example="1",
 *                 ),
 *                 required={""}
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
public function get_food_menu_details_post() {}
/**
 * @OA\Post(
 *     path="/api/v1/Sale/get_delivery_partners",
 *     summary="Get Delivery Partners",
 *     tags={"Panel - Common"},
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Access-Token",
 *         in="header",
 *         required=true),
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Checksum",
 *         in="header",
 *         required=true),
 *     @OA\RequestBody(
 *         required=true,
 *        description="
 *          =================== 
 *          After provide the email and password system will provide the object response if everyting is success, otherwise it will proivde error with message 
 *          ===================",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 @OA\Property(
 *                     property="company_id",
 *                     type="string",
*                     example="1",
 *                 ),
 *                 required={""}
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
public function get_delivery_partners_post() {}


/**
 * @OA\Post(
 *     path="/api/v1/Sale/pos",
 *     summary="POS Screen",
 *     tags={"Panel - Common"},
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Access-Token",
 *         in="header",
 *         required=true),
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Checksum",
 *         in="header",
 *         required=true),
 *     @OA\RequestBody(
 *         required=true,
 *        description="
 *          =================== 
 *          After provide the email and password system will provide the object response if everyting is success, otherwise it will proivde error with message 
 *          ===================",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 example={
 *                     "outlet_id": "1",
 *                 }
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
public function pos_post() {}


/**
 * @OA\Post(
 *     path="/api/v1/Sale/push_order",
 *     summary="Push Final Sale data",
 *     tags={"Panel - Common"},
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Access-Token",
 *         in="header",
 *         required=true),
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Checksum",
 *         in="header",
 *         required=true),
 *     @OA\RequestBody(
 *         required=true,
 *         description="Super admin will get the order from api",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 example={
 *                     "sale_no": "sQA240604-001",
 *                     "waiter_app_status": "No",
 *                     "outlet_id": "1",
 *                     "hidden_given_amount": "1510.00",
 *                     "hidden_change_amount": "0.00",
 *                     "random_code": "h9M6PBUzcEccnzy",
 *                     "token_number": "",
 *                     "customer_name": "Walk-in Customer",
 *                     "customer_address": "",
 *                     "customer_phone": "123456",
 *                     "customer_email": "",
 *                     "customer_gst_number": "",
 *                     "status": "Pending",
 *                     "user_name": "Super Admin",
 *                     "user_id": "1",
 *                     "delivery_partner_id": "",
 *                     "self_order_table_id": "0",
 *                     "self_order_table_person": "undefined",
 *                     "rounding_amount_hidden": "0.00",
 *                     "previous_due_tmp": "0",
 *                     "waiter_id": "45",
 *                     "waiter_name": "Michael Wyatt",
 *                     "open_invoice_date_hidden": "2024-06-04",
 *                     "total_items_in_cart": "3",
 *                     "total_items_in_cart_qty": "8",
 *                     "sub_total": "1510.00",
 *                     "sale_date": "2024-06-04",
 *                     "date_time": "2024-06-04 16:59:25",
 *                     "order_time": "16:59:25",
 *                     "charge_type": "service",
 *                     "total_vat": "229.27",
 *                     "total_payable": "1510.00",
 *                     "total_item_discount_amount": "0.00",
 *                     "sub_total_with_discount": "1510.00",
 *                     "sub_total_discount_amount": "0.00",
 *                     "total_discount_amount": "0.00",
 *                     "delivery_charge": "",
 *                     "tips_amount": "",
 *                     "delivery_charge_actual_charge": "",
 *                     "tips_amount_actual_charge": "0.00",
 *                     "sub_total_discount_value": "",
 *                     "sub_total_discount_type": "percentage",
 *                     "order_type": "1",
 *                     "order_status": 3,
 *                     "sale_vat_objects": "[{'tax_field_id':'1','tax_field_type':'CGST','tax_field_amount':'71.90'},{'tax_field_id':'1','tax_field_type':'SGST','tax_field_amount':'0'},{'tax_field_id':'1','tax_field_type':'IGST','tax_field_amount':'85.47'},{'tax_field_id':'1','tax_field_type':'VAT','tax_field_amount':'71.90'}]",
 *                     "orders_table_text": "Table 001",
 *                     "items": "[{'food_menu_id':'4','is_print':'1','is_kot_print':'1','menu_name':'Burger','kitchen_id':'6','kitchen_name':'KOT-Kitchen','is_free':'0','rounding_amount_hidden':'0','menu_discount_value': '','discount_type': 'fixed','menu_price_without_discount': '20.00','menu_unit_price': '20.00','qty': '1','tmp_qty': '','p_qty': '','item_previous_id': '','item_cooking_done_time': '','item_cooking_start_time': '','item_cooking_status': '','item_type': '','menu_price_with_discount': '20.00','item_discount_amount': '0.00','modifiers_id': '1,2','modifiers_name': 'Mod 1, Mod 2','modifiers_price': '1.2,1000.00','modifier_vat': '[]|||[]','item_note': '','menu_combo_items': '','item_vat':[{'tax_field_id':'1','tax_field_company_id':'1','tax_field_name':'CGST','tax_field_percentage':'5','item_vat_amount_for_unit_item':'1','item_vat_amount_for_all_quantity':'1'},{'tax_field_id':'1','tax_field_company_id':'1','tax_field_name':'SGST','tax_field_percentage':'0','item_vat_amount_for_unit_item':'0','item_vat_amount_for_all_quantity':'0'},{'tax_field_id':'1','tax_field_company_id':'1','tax_field_name':'IGST','tax_field_percentage':'6','item_vat_amount_for_unit_item':'1.20','item_vat_amount_for_all_quantity':'1.20'},{'tax_field_id':'1','tax_field_company_id':'1','tax_field_name':'VAT','tax_field_percentage':'5','item_vat_amount_for_unit_item':'1','item_vat_amount_for_all_quantity':'1'}]}]",
 *                     "is_multi_currency": "",
 *                     "multi_currency": "",
 *                     "multi_currency_rate": "",
 *                     "multi_currency_amount": "",
 *                     "payment_object": "[{'payment_id':'1','payment_name':'Cash','usage_point':'','amount':'1510'}]",
 *                 }
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
public function push_order_post() {}

/**
 * @OA\Post(
 *     path="/api/v1/Sale/remove_notication",
 *     summary="Remove Single Notification",
 *     tags={"Panel - Common"},
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Access-Token",
 *         in="header",
 *         required=true),
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Checksum",
 *         in="header",
 *         required=true),
 *     @OA\RequestBody(
 *         required=true,
 *        description="
 *          =================== 
 *          After provide the email and password system will provide the object response if everyting is success, otherwise it will proivde error with message 
 *          ===================",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 example={
 *                     "notification_id": "1",
 *                 }
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
public function remove_notication_post() {}
/**
 * @OA\Post(
 *     path="/api/v1/Sale/remove_multiple_notification",
 *     summary="Remove Multiple Notification",
 *     tags={"Panel - Common"},
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Access-Token",
 *         in="header",
 *         required=true),
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Checksum",
 *         in="header",
 *         required=true),
 *     @OA\RequestBody(
 *         required=true,
 *        description="
 *          =================== 
 *          After provide the email and password system will provide the object response if everyting is success, otherwise it will proivde error with message 
 *          ===================",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 example={
 *                     "notification_id": "1,2,3",
 *                 }
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
public function remove_multiple_notification_post() {}
/**
 * @OA\Post(
 *     path="/api/v1/Sale/add_customer_pos",
 *     summary="Add Customer",
 *     tags={"Panel - Common"},
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Access-Token",
 *         in="header",
 *         required=true),
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Checksum",
 *         in="header",
 *         required=true),
 *     @OA\RequestBody(
 *         required=true,
 *        description="
 *          =================== 
 *          After provide the email and password system will provide the object response if everyting is success, otherwise it will proivde error with message 
 *          ===================",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 example={
 *                     "name": "Mr. Joe",
 *                     "phone": "123456789",
 *                     "email": "joe@gmail.com",
 *                     "default_discount": "10%",
 *                     "date_of_birth": "2024-05-30",
 *                     "date_of_anniversary": "2024-05-30",
 *                     "address": "34, New York",
 *                     "gst_number": "564646",
 *                     "same_or_diff_state": "1",
 *                 }
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
public function add_customer_pos_post() {}
/**
 * @OA\Post(
 *     path="/api/v1/Sale/edit_customer_pos",
 *     summary="Edit Customer",
 *     tags={"Panel - Common"},
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Access-Token",
 *         in="header",
 *         required=true),
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Checksum",
 *         in="header",
 *         required=true),
 *     @OA\RequestBody(
 *         required=true,
 *        description="
 *          =================== 
 *          After provide the email and password system will provide the object response if everyting is success, otherwise it will proivde error with message 
 *          ===================",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 @OA\Property(
 *                     property="id",
 *                     type="string",
*                     example="1",
 *                 ),
 *                 required={""}
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
public function edit_customer_pos_post() {}
/**
 * @OA\Post(
 *     path="/api/v1/Sale/store_edit_customer_pos",
 *     summary="Store Customer Data",
 *     tags={"Panel - Common"},
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Access-Token",
 *         in="header",
 *         required=true),
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Checksum",
 *         in="header",
 *         required=true),
 *     @OA\RequestBody(
 *         required=true,
 *        description="
 *          =================== 
 *          After provide the email and password system will provide the object response if everyting is success, otherwise it will proivde error with message 
 *          ===================",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 example={
 *                     "id": "2",
 *                     "name": "Mr. Joe",
 *                     "phone": "123456789",
 *                     "email": "joe@gmail.com",
 *                     "default_discount": "10%",
 *                     "date_of_birth": "2024-05-30",
 *                     "date_of_anniversary": "2024-05-30",
 *                     "address": "34, New York",
 *                     "gst_number": "564646",
 *                     "same_or_diff_state": "1",
 *                 }
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
public function store_edit_customer_pos_post() {}
/**
 * @OA\Post(
 *     path="/api/v1/Sale/get_promo",
 *     summary="Get Promo",
 *     tags={"Panel - Common"},
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Access-Token",
 *         in="header",
 *         required=true),
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Checksum",
 *         in="header",
 *         required=true),
 *     @OA\RequestBody(
 *         required=true,
 *        description="
 *          =================== 
 *          After provide the email and password system will provide the object response if everyting is success, otherwise it will proivde error with message 
 *          ===================",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 example={
 *                     "outlet_id": "1",
 *                 }
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
public function get_promo_post() {}
/**
 * @OA\Post(
 *     path="/api/v1/Sale/order_status_screen",
 *     summary="Order Status Screen",
 *     tags={"Panel - Common"},
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Access-Token",
 *         in="header",
 *         required=true),
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Checksum",
 *         in="header",
 *         required=true),
 *     @OA\RequestBody(
 *         required=true,
 *         description="For Ready to Pickup status will be 1 and for Preparing setatus will be 2 or 3",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 example={
 *                     "outlet_id": "1",
 *                 }
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
public function order_status_screen_post() {}
/**
 * @OA\Post(
 *     path="/api/v1/Sale/customer_display",
 *     summary="Customer Display",
 *     tags={"Panel - Common"},
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Access-Token",
 *         in="header",
 *         required=true),
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Checksum",
 *         in="header",
 *         required=true),
 *     @OA\RequestBody(
 *         required=true,
 *        description="
 *          =================== 
 *          After provide the email and password system will provide the object response if everyting is success, otherwise it will proivde error with message 
 *          ===================",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 example={
 *                     "user_id": "1",
 *                 }
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
public function customer_display_post() {}

 /**
 * @OA\POST(
 *     path="/api/v1/Sale/get_self_orders",
 *     summary="Get Self Orders",
 *     tags={"Panel - Common"},
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Access-Token",
 *         in="header",
 *         required=true),
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Checksum",
 *         in="header",
 *         required=true),
 *     @OA\RequestBody(
 *         required=true,
 *        description="
 *          =================== 
 *          After provide the email and password system will provide the object response if everyting is success, otherwise it will proivde error with message 
 *          ===================",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 example={
 *                     "outlet_id": "1",
 *                      "user_id":"1",
 *                 }
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
public function get_self_orders_post() {}
 /**
 * @OA\POST(
 *     path="/api/v1/Sale/get_online_orders",
 *     summary="Get Online Orders",
 *     tags={"Panel - Common"},
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Access-Token",
 *         in="header",
 *         required=true),
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Checksum",
 *         in="header",
 *         required=true),
 *     @OA\RequestBody(
 *         required=true,
 *        description="
 *          =================== 
 *          After provide the email and password system will provide the object response if everyting is success, otherwise it will proivde error with message 
 *          ===================",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 example={
 *                     "outlet_id": "1",
 *                      "user_id":"1",
 *                 }
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
public function get_online_orders_post() {}
/**
 * @OA\POST(
 *     path="/api/v1/Sale/accept_order",
 *     summary="Accept Order",
 *     tags={"Panel - Common"},
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Access-Token",
 *         in="header",
 *         required=true),
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Checksum",
 *         in="header",
 *         required=true),
 *     @OA\RequestBody(
 *         required=true,
 *        description="
 *          =================== 
 *          After provide the email and password system will provide the object response if everyting is success, otherwise it will proivde error with message 
 *          ===================",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 example={
 *                     "sale_id": "1",
 *                 }
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
public function accept_order_post() {}
/**
 * @OA\POST(
 *     path="/api/v1/Sale/decline_order",
 *     summary="Decline Order",
 *     tags={"Panel - Common"},
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Access-Token",
 *         in="header",
 *         required=true),
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Checksum",
 *         in="header",
 *         required=true),
 *     @OA\RequestBody(
 *         required=true,
 *        description="
 *          =================== 
 *          After provide the email and password system will provide the object response if everyting is success, otherwise it will proivde error with message 
 *          ===================",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 example={
 *                     "sale_id": "1",
 *                 }
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
public function decline_order_post() {}
/**
 * @OA\POST(
 *     path="/api/v1/Sale/cancel_order",
 *     summary="Decline Order",
 *     tags={"Panel - Common"},
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Access-Token",
 *         in="header",
 *         required=true),
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Checksum",
 *         in="header",
 *         required=true),
 *     @OA\RequestBody(
 *         required=true,
 *        description="
 *          =================== 
 *          After provide the email and password system will provide the object response if everyting is success, otherwise it will proivde error with message 
 *          ===================",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 example={
 *                     "sale_id": "1",
 *                     "user_id": "1",
 *                     "reason": "Guest cancelled the order",
 *                 }
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
public function cancel_order_post() {} 

/**
 * @OA\Post(
 *     path="/api/v1/Common/get_reservations",
 *     summary="Get Reservations",
 *     tags={"Panel - Reservation"},
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Access-Token",
 *         in="header",
 *         required=true),
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Checksum",
 *         in="header",
 *         required=true),
 *     @OA\RequestBody(
 *         required=true,
 *         description="
 *          =================== 
 *          system will provide the reservations if required fields data provided there.  
 *          ===================",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 example={
 *                     "outlet_id": "1",
 *                 }
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
public function get_reservations_post() {}

/**
 * @OA\Post(
 *     path="/api/v1/Common/change_status_reservation",
 *     summary="Change Status Reservation",
 *     tags={"Panel - Reservation"},
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Access-Token",
 *         in="header",
 *         required=true),
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Checksum",
 *         in="header",
 *         required=true),
 *     @OA\RequestBody(
 *         required=true,
 *         description="
 *          =================== 
 *          system will change the status of the reservation if required fields data provided there, status will be Accept, Pending, Decline, Done, No Appear.  
 *          ===================",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 example={
 *                     "id": "1",
 *                     "status": "Accept",
 *                 }
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
public function change_status_reservation_post() {}

/**
 * @OA\Post(
 *     path="/api/v1/Common/remove_reservation",
 *     summary="Remove Reservation",
 *     tags={"Panel - Reservation"},
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Access-Token",
 *         in="header",
 *         required=true),
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Checksum",
 *         in="header",
 *         required=true),
 *     @OA\RequestBody(
 *         required=true,
 *         description="
 *          =================== 
 *          system will remove the reservation if required fields data provided there.  
 *          ===================",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 example={
 *                     "id": "1",
 *                 }
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
public function remove_reservation_post() {}
/**
 * @OA\POST(
 *     path="/api/v1/Kitchen/kitchens",
 *     summary="Get Kitchens",
 *     tags={"Kitchen - KDS"},
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Access-Token",
 *         in="header",
 *         required=true),
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Checksum",
 *         in="header",
 *         required=true),
 *     @OA\RequestBody(
 *         required=true,
 *        description="
 *          =================== 
 *          After provide the company_id system will provide the object response if everyting is success, otherwise it will proivde error with message 
 *          ===================",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 example={
 *                     "company_id": "1",
 *                 }
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
public function kitchens_post() {} 
/**
 * @OA\POST(
 *     path="/api/v1/Kitchen/panel",
 *     summary="Get Panel",
 *     tags={"Kitchen - KDS"},
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Access-Token",
 *         in="header",
 *         required=true),
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Checksum",
 *         in="header",
 *         required=true),
 *     @OA\RequestBody(
 *         required=true,
 *        description="
 *          =================== 
 *          After provide the outlet_id and kitchen_id system will provide the object response if everyting is success, otherwise it will proivde error with message 
 *          ===================",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 example={
 *                     "outlet_id": "1", 
 *                     "kitchen_id": "2", 
 *                 }
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
public function panel_post() {} 
/**
 * @OA\POST(
 *     path="/api/v1/Kitchen/change_kitchen_status",
 *     summary="Change Kitchen Status",
 *     tags={"Kitchen - KDS"},
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Access-Token",
 *         in="header",
 *         required=true),
 *       @OA\Parameter(
 *         type="string",                                                                                                                                                                              
 *         name="Checksum",
 *         in="header",
 *         required=true),
 *     @OA\RequestBody(
 *         required=true,
 *        description="
 *          =================== 
 *          After provide the item_ids and cooking_status (value will be Cook for Started Cooking and Done for Done) system will provide the object response if everyting is success, otherwise it will proivde error with message 
 *          ===================",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 example={
 *                     "item_ids": "1,2,3", 
 *                     "cooking_status": "Started Cooking", 
 *                 }
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
public function change_kitchen_status_post() {} 
 

public function set_swagger_config_get(){
  require("vendor/autoload.php");

$openapi = \OpenApi\Generator::scan(['application/controllers/api/v1']);

// Convert to array to manipulate the structure
$data = json_decode($openapi->toJson(), true);

// Set the correct servers block
$data['servers'] = [
 [
     'url' => 'https://doorsoft-demo.com/irestora_plus_app'
 ]
];

// Output the modified JSON
header('Content-Type: application/json');
echo json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

  } 
}