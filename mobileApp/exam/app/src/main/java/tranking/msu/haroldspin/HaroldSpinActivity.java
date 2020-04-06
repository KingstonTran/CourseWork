package tranking.msu.haroldspin;

import androidx.appcompat.app.AppCompatActivity;

import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;

public class HaroldSpinActivity extends AppCompatActivity {
    private static final String PARAMETERS = "parameters";
    private HaroldSpinView haroldSpinView;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.haroldspin_main);
        haroldSpinView = this.findViewById(R.id.haroldSpinView);
        /*
         * Restore any state
         */
        if(savedInstanceState != null) {
            haroldSpinView.getFromBundle(PARAMETERS, savedInstanceState);
            setButtonSpin();
            setSpinText();
            haroldSpinView.invalidate();
        }

    }
    public void onSpin(View view) {
        Button spinButton = findViewById(R.id.buttonSpin);
        String buttonText = spinButton.getText().toString();
        String startSpin = this.getString(R.string.spinString);
        if (buttonText.equals(startSpin)){
            spinButton.setText(R.string.stopString);
            haroldSpinView.setSpinning(true);
            haroldSpinView.calculateTimesSpinned();
            setSpinText();
        }
        else {

            haroldSpinView.setSpinning(false);
            haroldSpinView.setStopped(true);
            haroldSpinView.calculateMoney();
            spinButton.setText(R.string.spinString);
            setSpinText();
        }
        haroldSpinView.invalidate();
    }

    public void onNewGame(View view){
        Button spinButton= findViewById(R.id.buttonSpin);
        spinButton.setText(R.string.spinString);
        haroldSpinView.newGame();
        haroldSpinView.invalidate();
        setSpinText();
    }


    public void setButtonSpin(){
        Button spinButton= findViewById(R.id.buttonSpin);
        if (haroldSpinView.getSpinning()){
            spinButton.setText(R.string.stopString);
        }
        else{
            spinButton.setText(R.string.spinString);
        }
    }
    public void setSpinText(){
        TextView texts = findViewById(R.id.textSpin);
        int spins = haroldSpinView.getTimesSpinned();
        int money = haroldSpinView.getMoneyAmt();
        String text = getResources().getString(R.string.spinsLabel) + spins + " " + getResources().getString(R.string.winningsLabel)+money;
        texts.setText(text);

    }

    @Override
    protected void onSaveInstanceState(Bundle bundle) {
        super.onSaveInstanceState(bundle);
        haroldSpinView.putToBundle(PARAMETERS, bundle);
    }
}
