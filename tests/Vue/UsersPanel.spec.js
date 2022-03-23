import {mount} from '@vue/test-utils';
import UsersPanel from '../../resources/js/components/UsersPanel.vue';
import { PusherMock, PusherFactoryMock } from "pusher-js-mock";

const pusherFactoryMock = new PusherFactoryMock();
window.Pusher = pusherFactoryMock;
let pusher = pusherFactoryMock.pusherClient();
describe('ChatPanel.vue', () => {


    let wrapper;
    let getRoomsMock;

    const mockUsers = [
        {id:1 , name: "test1", online: true},
        {id:2 , name: "test2", online: false},
        {id:3 , name: "test3", online: true}
    ]

    beforeAll(()=> {

        getRoomsMock = jest.spyOn(UsersPanel.methods, 'getRooms').mockReturnValue(mockUsers);
        wrapper = mount(UsersPanel);

    })

    it('method getRooms should be mounted', () => {
       expect(getRoomsMock).toBeCalled();
    })
    it('should return all users in room', () =>{

        expect(wrapper.vm.users.length).toBe(3);

    });
})
