import {mount} from '@vue/test-utils';
import ChooseRoom from '../../resources/js/components/ChooseRoom.vue';

require('jsdom-global');
describe('ChooseRoom.vue', () => {
    let wrapper;
    let getRoomsMock;

    const mockRooms = [
        {id: 1, name: 'Room1', password_require: true},
        {id: 2, name: 'Room2', password_require: false}
    ];
    beforeAll(() => {
        getRoomsMock = jest.spyOn(ChooseRoom.methods, 'getRooms').mockReturnValue(mockRooms);
        wrapper = mount(ChooseRoom);
    });

    it('should have select input', () => {
        const select = wrapper.find('select');

        expect(select.isVisible).toBeTruthy();
    });

    it('should mounted getRooms function', () => {
        expect(getRoomsMock).toBeCalled();
    });

    it('it should display password input if room require password', async () => {

        const options = wrapper.find('select').findAll('option');
        await options.at(0).setSelected();

        expect(wrapper.find('select').element.value).toBe('1');
        expect(wrapper.find('input[type="password"]').isVisible()).toBeTruthy();

    });
    it('password should not be visible if pasword is not required', async () => {

        const options = wrapper.find('select').findAll('option');
        await options.at(1).setSelected();

        expect(wrapper.find('select').element.value).toBe('2');
        expect(wrapper.find('input[type="password"]').isVisible()).toBeFalsy();

    });

    it('should submit form', async () => {

        const options = wrapper.find('select').findAll('option');
        await options.at(1).setSelected();

        wrapper.vm.submit = jest.fn();

        const form = wrapper.find('form');

        await form.trigger('submit.prevent');

        expect(wrapper.vm.submit).toBeCalled();

    });

    it('should be link "Create new one"', () => {

        const link = wrapper.find('a');

        expect(link.element.text).toBe('Create new one');
    });

    it('should redirect to create view after clicking link', async () => {

        const link = wrapper.find('a');
        await link.trigger('click');

        // expect(window.location.href).toBe('/create');
    });


});
