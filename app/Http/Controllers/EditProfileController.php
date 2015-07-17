<?php namespace App\Http\Controllers;
use App\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Input;
use Session;
use Illuminate\Support\Facades\Validator;
class EditProfileController extends Controller {


  public function edit(Request $input) { 
   
    $userid = session('userid');
    $user = User::find($userid);
    $avatar=User::getAvatarbyId($userid);
    $name=User::getNamebyId($userid);
    
       
    return view('editprofile',compact('user','avatar','name'));
             
  }
  
  public function editprofile(Request $request){
    $name = $request->get('name');

    $email = $request->get('email');

    $current= md5(sha1($request->get('current')));
    $new=$request->get('new');
    $retype=$request->get('retype');

    $userid = session('userid');
    $user = new User();

    $user = User::find($userid);
    $pwd=$user->password;
    Session::flash('success', "Changed success!");

    if ($name!=""&&$email!=""&&Input::file('image')!=""&&$current!=""&&$new!=""&&$retype!="") {
            if ($user->username_exist($name)) {        
            return Redirect::to('information')->withErrors('This username is already exists');
            }
            elseif ($user->email_exist($email)) {
              return Redirect::to('information')->withErrors('This email is already exists');
            }elseif ($current==$pwd) {
                  if ($new==$retype){
                          $user->update_password($new,$userid);
                          $user->update_name($name,$userid);
                          $user->update_email($email,$userid);
                          $filename = Input::file('image')->getClientOriginalName();
            
                           $destinationPath = base_path("resources\assets\img");
                           $extension = Input::file('image')->getClientOriginalExtension(); // getting image extension
                           $fileName = rand(11111,99999).'.'.$extension; 
             
             
                           Input::file('image')->move($destinationPath, $fileName);
                           
                           $user = new User();
                           $user = User::where("id","=",$userid)->update(['avatar' => '../resources/assets/img/'.$fileName]);

                          return Redirect::to('information');
                        }else return Redirect::to('information')->withErrors('Passwords do not match'); 
                  }else return Redirect::to('information')->withErrors('Invalid password');
                  
                }
      else{

                  if ($name!="") {
                  if ($user->username_exist($name)) {        
                    return Redirect::to('information')->withErrors('This username is already exists');
                  }else{
                      $user->update_name($name,$userid);
                    }
                  }

                 if ($email!="") {
                  if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                    return Redirect::to('information')->withErrors('Your address is not valid');

                  }else {
                    if ($user->email_exist($email)) {
                    return Redirect::to('information')->withErrors('This email is already exists');
                    }else{
                          $user->update_email($email,$userid);
                    }
                  }
                  
                }

                  if (Input::file('image')!="") {
                       $filename = Input::file('image')->getClientOriginalName();
                      
                       $destinationPath = base_path("resources\assets\img");
                       $extension = Input::file('image')->getClientOriginalExtension(); // getting image extension
                       $fileName = rand(11111,99999).'.'.$extension; 
                       
                       
                       Input::file('image')->move($destinationPath, $fileName);
                       
                       $user = new User();
                       $user = User::where("id","=",$userid)->update(['avatar' => '../resources/assets/img/'.$fileName]);       
                 }

                 if ($current!=""&&$new!=""&&$retype!="") {
                      if ($current==$pwd) {
                        if ($new==$retype){
                                $user->update_password($new,$userid);
                              }
                              else return Redirect::to('information')->withErrors('Passwords do not match'); 
                        }else return Redirect::to('information')->withErrors('Invalid password');
                        
                      }
                      if ($current==""&&$new==""&&$retype=="") {
                        if ($name!="") {
                          if ($user->username_exist($name)) {        
                            return Redirect::to('information')->withErrors('This username is already exists');
                          }else{
                              $user->update_name($name,$userid);
                            }
                          }

                         if ($email!="") {
                          
                           
                            if(!filter_var($email, FILTER_VALIDATE_EMAIL))
                              {
                                return Redirect::to('information')->withErrors('Your address is not valid');
                                
                              }
                           else
                             {
                              if ($user->email_exist($email)) {
                                  return Redirect::to('information')->withErrors('This email is already exists');
                                }else{
                                      $user->update_email($email,$userid);
                                }
                             }
                          
                        }return Redirect::to('information')->withErrors('The field password is not empty');
                       
                      }
          }        
             return Redirect::to('information');             
          }
            } 
              


