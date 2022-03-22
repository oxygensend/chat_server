// tests/Vue/Counter.spec.Vue
import {mount} from '@vue/test-utils';
import CreateRoom from '../../resources/js/components/CreateRoom.vue';

require('jsdom-global');
describe('Counter.vue', () => {
    let wrapper;
    beforeAll(() => {


        wrapper = mount(CreateRoom,
       );
    });



    it('should have fields empty ', () => {

        expect(wrapper.vm.fields).toEqual({});
    });

    it('should fill text input', async () => {

        const name_input = wrapper.find('input[type="text"]');
        await name_input.setValue('Test room');

        expect(wrapper.find('input[type="text"]').element.value).toBe('Test room');
    });

    it('should fill password input', async () => {
        const password = wrapper.find('input[type="password"]');
        await password.setValue('Test password');

        expect(wrapper.find('input[type="password"]').element.value).toBe('Test password');
    });

    it('should not see password input defaultly', () => {

        const password = wrapper.find('input[type="password"]');
        expect(password.isVisible()).toBeFalsy();

    });

    it('password should be visible after clicking checkbox', async () => {

        const checkBox = wrapper.find('input[type="checkbox"]');
        const password = wrapper.find('input[type="password"]');
        await checkBox.trigger('click');

        expect(password.isVisible()).toBeTruthy();
        expect(wrapper.vm.password_selected).toBeTruthy();
    });

    it('should submit form', async () => {

        const name_input = wrapper.find('input[type="text"]');
        const password = wrapper.find('input[type="password"]');

        await name_input.setValue('Test room');
        await password.setValue('Test password');

        wrapper.vm.submit = jest.fn();

        const form = wrapper.find('form');

        await form.trigger('submit.prevent');

        expect(wrapper.vm.submit).toBeCalled();


    });

    it('should be link "Choose existing"', () => {

        const link = wrapper.find('a');

        expect(link.element.text).toBe('Choose existing');
    });

    it('should redirect to choose room view after clicking link', async () => {

        const link = wrapper.find('a');
        await link.trigger('click');

        // expect(window.location.pathname).toBe('/');
    });


});
