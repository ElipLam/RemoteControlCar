package course.dathuynh.carcontroller.activity;

import android.app.ProgressDialog;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.AsyncTask;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.view.View;
import android.view.Window;
import android.view.WindowManager;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;

import course.dathuynh.carcontroller.Constants;
import course.dathuynh.carcontroller.util.JSONParser;
import course.dathuynh.carcontroller.R;

public class ChangePasswordActivity extends AppCompatActivity {
    private static final String TAG = "ChangePasswordActivity";

    private static int RESULT_SUCCESS = 0;

    JSONParser jsonParser = new JSONParser();

    EditText _currentPass;
    EditText _newPass;
    EditText _retypePass;
    Button _changeButton;

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        requestWindowFeature(Window.FEATURE_NO_TITLE);
        getWindow().setFlags(WindowManager.LayoutParams.FLAG_LAYOUT_NO_LIMITS, WindowManager.LayoutParams.FLAG_LAYOUT_NO_LIMITS);
        setContentView(R.layout.activity_changepassword);

        _currentPass = (EditText) findViewById(R.id.chg_current_password);
        _newPass = (EditText) findViewById(R.id.chg_new_password);
        _retypePass = (EditText) findViewById(R.id.chg_retype_Password);
        _changeButton = (Button) findViewById(R.id.btn_change);

        _changeButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                changepassword();
            }
        });


    }

    public void changepassword() {
        Log.d(TAG, "ChangePassword");

        if (!validate()) {
            onChangePasswordFailed();
            return;
        }

        _changeButton.setEnabled(false);

        final ProgressDialog progressDialog = new ProgressDialog(ChangePasswordActivity.this,
                R.style.AppTheme_Dark_Dialog);
        progressDialog.setIndeterminate(true);
        progressDialog.setMessage("Changing Password...");
        progressDialog.show();

        SharedPreferences pref = getSharedPreferences(Constants.PREFS_NAME, MODE_PRIVATE);
        String username = pref.getString(Constants.PREF_USERNAME, null);
        String current = _currentPass.getText().toString();
        String neww = _newPass.getText().toString();

        //Implement your own change password logic here.
        AttemptChangePassword attemptChange = new AttemptChangePassword();
        attemptChange.execute(username, current, neww);

        new android.os.Handler().postDelayed(
                new Runnable() {
                    public void run() {
                        // On complete call either onSignupSuccess or onSignupFailed
                        // depending on success
                        if (RESULT_SUCCESS == 1)
                            onChangePasswordSuccess();
                        else onChangePasswordFailed();
                        progressDialog.dismiss();
                    }
                }, 3000);
    }


    public void onChangePasswordSuccess() {
        _changeButton.setEnabled(true);
        setResult(RESULT_OK, null);
        Intent intent = new Intent(this, MainActivity.class);
        startActivity(intent);
        finish();
    }

    public void onChangePasswordFailed() {
        Toast.makeText(getBaseContext(), "Change password failed", Toast.LENGTH_LONG).show();

        _changeButton.setEnabled(true);
    }

    public boolean validate() {
        boolean valid = true;

        String current = _currentPass.getText().toString();
        String neww = _newPass.getText().toString();
        String retypepass = _retypePass.getText().toString();

        _currentPass.setError(null);
        if (current.isEmpty() || current.length() < 2) {
            _currentPass.setError("at least 2 characters");
            valid = false;
        }
        _newPass.setError(null);
        if (neww.equals(current) ) {
            _newPass.setError("New password is same Current password");
            valid = false;
        }

        if (neww.isEmpty() || neww.length() < 2 || neww.length() > 10 ) {
            _newPass.setError("between 2 and 10 alphanumeric characters");
            valid = false;
        }

        _retypePass.setError(null);
        if (retypepass.isEmpty() || retypepass.length() < 2 || retypepass.length() > 10 || !(retypepass.equals(neww))) {
            _retypePass.setError("Retype password do not match");
            valid = false;
        }

        return valid;
    }


    private class AttemptChangePassword extends AsyncTask<String, String, JSONObject> {

        @Override

        protected void onPreExecute() {

            super.onPreExecute();

        }

        @Override

        protected JSONObject doInBackground(String... args) {

            String username = args[0];
            String current_password = args[1];
            String new_password = args[2];

            ArrayList<NameValuePair> params = new ArrayList<NameValuePair>();
            params.add(new BasicNameValuePair("username", username));
            params.add(new BasicNameValuePair("currentpassword", current_password));
            params.add(new BasicNameValuePair("newpassword", new_password));

            JSONObject json = jsonParser.makeHttpRequest(Constants.URL_ChangePassword, "POST", params);

            return json;

        }

        protected void onPostExecute(JSONObject result) {

            try {
                if (result != null) {
                    Toast.makeText(getApplicationContext(), result.getString("message"), Toast.LENGTH_LONG).show();
                    RESULT_SUCCESS = result.getInt("success");
                } else {
                    Toast.makeText(getApplicationContext(), "Unable to retrieve any data from server", Toast.LENGTH_LONG).show();
                }
            } catch (JSONException e) {
                e.printStackTrace();
            }
        }

    }
}
