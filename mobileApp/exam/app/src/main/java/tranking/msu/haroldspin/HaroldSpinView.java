package tranking.msu.haroldspin;

import android.content.Context;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.graphics.Canvas;
import android.graphics.Color;
import android.graphics.LightingColorFilter;
import android.graphics.Paint;
import android.os.Bundle;
import android.util.AttributeSet;
import android.view.MotionEvent;
import android.view.View;

import java.io.Serializable;
import java.util.Random;

public class HaroldSpinView extends View {
    private final static double START_RATE = 2.0;
    private final static double SPEEDUP = 1.01;
    private int money[][] = {{1, 5, 100, -1},
            {-1, 100, 1, 50},
            {5, 50, -1, 20},
            {10, 10, -1, 1}};

    private float imageScale = 1;
    /**
     * Image left margin in pixels
     */
    private float marginLeft = 0;

    /**
     * Image top margin in pixels
     */
    private float marginTop = 0;
    private Random randomizer = new Random();
    private Bitmap boardBitmap = null;
    private Paint redBox;
    /**
     * The bitmap to draw the hat
     */

    /**
     * The current parameters
     */

    public HaroldSpinView(Context context) {
        super(context);
        init(null, 0);
    }

    public HaroldSpinView(Context context, AttributeSet attrs) {
        super(context, attrs);
        init(attrs, 0);
    }

    public HaroldSpinView(Context context, AttributeSet attrs, int defStyle) {
        super(context, attrs, defStyle);
        init(attrs, defStyle);
    }

    private void init(AttributeSet attrs, int defStyle) {
        boardBitmap = BitmapFactory.decodeResource(getResources(), R.drawable.haroldgrid);
        redBox = new Paint(Paint.ANTI_ALIAS_FLAG);
        redBox.setColor(Color.RED);
        redBox.setStrokeWidth(10);
        redBox.setStyle(Paint.Style.STROKE);
    }

    private static class Parameters implements Serializable {
        private int moneyAmt = 0;
        private int timesSpinned = 0;
        private int randomX = 0;
        private int randomY = 0;

        /**
         * True when the red box is spinning
         */
        private boolean spinning = false;

        /**
         * Spin rate in boxes per second
         */
        private double spinRate = START_RATE;

        /**
         * Time we last called onDraw
         */
        private long lastTime = 0;

        /**
         * How long a box has been on the screen
         */
        private double duration = 0;
        private boolean stopped = false;
    }

    private Parameters params = new Parameters();

    /**
     * Handle a draw event
     *
     * @param canvas canvas to draw on.
     */
    @Override
    protected void onDraw(Canvas canvas) {
        super.onDraw(canvas);
        float wid = getWidth();
        float hit = getHeight();
        float scaleH = wid / boardBitmap.getWidth();
        float scaleV = hit / boardBitmap.getHeight();
        imageScale = scaleH < scaleV ? scaleH : scaleV;
//        imageScale = (float) (imageScale - (imageScale * 0.01));
        float iWid = imageScale * boardBitmap.getWidth();
        float iHit = imageScale * boardBitmap.getHeight();
        marginLeft = (wid - iWid) / 2;
        marginTop = (hit - iHit) / 6;
        canvas.save();
        canvas.translate(marginLeft, marginTop);
        canvas.scale(imageScale, imageScale);
        canvas.drawBitmap(boardBitmap, 0, 0, null);
        canvas.restore();

//        invalidate();
        if (params.spinning) {
            long time = System.currentTimeMillis();
            double delta = (time - params.lastTime) * 0.001;
            params.lastTime = time;

            params.duration += delta;
            if (params.duration >= 1.0 / params.spinRate) {
                randomLocation();
                params.spinRate *= SPEEDUP;
                params.duration = 0;
            }
            drawBox(canvas);
            postInvalidate();
        }
        else if (params.stopped) {
            drawBox(canvas);
        }

    }
    public void drawBox(Canvas canvas){
        float iWid = imageScale * boardBitmap.getWidth();
        float iHit = imageScale * boardBitmap.getHeight();
        float boxSizeX= iWid/8;
        float boxSizeY=iHit/8;
        float boxCenterX=marginLeft+((2*params.randomX+1)*boxSizeX);
        float boxCenterY=marginTop+((2*params.randomY+1)*boxSizeY);
        canvas.save();
        canvas.translate(boxCenterX, boxCenterY);
        canvas.rotate(0);
        canvas.drawRect(-boxSizeX, -boxSizeY, boxSizeX, boxSizeY, redBox);
        canvas.restore();
    }
    public void setSpinning(boolean spin) {
        params.spinning = spin;
    }

    public boolean getSpinning() {
        return params.spinning;
    }

    public void calculateTimesSpinned() {
        if (params.spinning) {
            params.timesSpinned++;
        }
    }
    public void setTimesSpinned(int currentSpins) {
        params.timesSpinned = currentSpins;
    }

    public int getTimesSpinned() {
        return params.timesSpinned;
    }

    public void setSpinRate(double rate) {
        params.spinRate = rate;
    }

    public void setStopped(boolean stop) {
        params.stopped = stop;
    }

    public void randomLocation() {
        // generate two random Integer [0-3]
        params.randomX = randomizer.nextInt(4);
        params.randomY = randomizer.nextInt(4);
    }

    public void setRandomX(int randomX) {
        params.randomX = randomX;
    }

    public void setRandomY(int randomY) {
        params.randomY = randomY;
    }

    public void calculateMoney() {
        if (money[params.randomY][params.randomX] == -1) {
            params.moneyAmt = 0;
        }
        else {
            params.moneyAmt += money[params.randomY][params.randomX];
        }
    }

    public int getMoneyAmt() {
        return params.moneyAmt;
    }

    public void setMoneyAmt(int currentMoney) {
        params.moneyAmt = currentMoney;
    }

    /**
     * Save the view state to a bundle
     *
     * @param key    key name to use in the bundle
     * @param bundle bundle to save to
     */
    public void putToBundle(String key, Bundle bundle) {
        bundle.putSerializable(key, params);
    }

    public void getFromBundle(String key, Bundle bundle) {
        params = (Parameters) bundle.getSerializable(key);
        setMoneyAmt(params.moneyAmt);
        setTimesSpinned(params.timesSpinned);
        setSpinning(params.spinning);
        setStopped(params.stopped);
        setSpinRate(params.spinRate);
        setRandomX(params.randomX);
        setRandomY(params.randomY);
    }
    public void newGame(){
        params.randomX = 0;
        params.randomY = 0;
        params.spinRate = START_RATE;
        params.moneyAmt = 0;
        params.timesSpinned = 0;
        params.spinning = false;
        params.stopped = false;
    }
}
