package course.dathuynh.carcontroller.model;

public class CarModel {

    public String CarName;
    public int state;

    /*
     * state = 0 - Offline
     * state = 1 - Online
     * state = 2 - Selected
     * state = 3 - Busy
     * */
    public CarModel(String CarName,  int State) {

        this.CarName = CarName;
        this.state = State;
    }
}

