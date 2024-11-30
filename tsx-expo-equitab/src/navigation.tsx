import { AppIcon } from "@/config/theme"
import AddFriendsModal from "@/modals/add-friends"
import CreateLedgerModal from "@/modals/create-ledger"
import FriendsScreen from "@/screens/friends"
import HomeScreen from "@/screens/home"
import SettingsScreen from "@/screens/settings"
import { createBottomTabNavigator } from "@react-navigation/bottom-tabs"
import { useNavigation } from "@react-navigation/native"
import { createNativeStackNavigator } from "@react-navigation/native-stack"
import { HeaderButtons, Item } from "react-navigation-header-buttons"
import IconHeaderButton from "./components/buttons/icon-header-button"

const RootStack = createNativeStackNavigator<RootStackParamList>()
export type RootStackParamList = Record<"App" | "AddFriends" | "CreateLedger", undefined>
export function RootStackNavigation() {
	return (
		<RootStack.Navigator>
			<RootStack.Screen
				name="App"
				component={RootTabNavigation}
				options={{ headerShown: false }}
			/>
			<RootStack.Group screenOptions={{ presentation: "modal" }}>
				<RootStack.Screen
					name="CreateLedger"
					component={CreateLedgerModal}
					options={{ headerTitle: "Create Ledger" }}
				/>
				<RootStack.Screen
					name="AddFriends"
					component={AddFriendsModal}
					options={{ headerTitle: "Add Friends" }}
				/>
			</RootStack.Group>
		</RootStack.Navigator>
	)
}

const RootTab = createBottomTabNavigator<RootTabParamList>()
export type RootTabParamList = Record<"Home" | "Friends" | "Settings", undefined>
export function RootTabNavigation() {
	const navigation = useNavigation()

	return (
		<RootTab.Navigator initialRouteName="Home">
			<RootTab.Screen
				name="Home"
				component={HomeScreen}
				options={{
					tabBarIcon: props => <AppIcon name="home" {...props} />,
					headerRight: () => (
						<HeaderButtons HeaderButtonComponent={IconHeaderButton}>
							<Item
								title="Create Ledger"
								iconName="add"
								onPress={() => {
									navigation.navigate("CreateLedger")
								}}
							/>
						</HeaderButtons>
					),
				}}
			/>
			<RootTab.Screen
				name="Friends"
				component={FriendsScreen}
				options={{
					tabBarIcon: props => <AppIcon name="people" {...props} />,
					headerShadowVisible: false,
					headerRight: () => (
						<HeaderButtons HeaderButtonComponent={IconHeaderButton}>
							<Item
								title="Add Friend"
								iconName="person-add"
								onPress={() => {
									navigation.navigate("AddFriends")
								}}
							/>
						</HeaderButtons>
					),
				}}
			/>
			<RootTab.Screen
				name="Settings"
				component={SettingsScreen}
				options={{ tabBarIcon: props => <AppIcon name="settings" {...props} /> }}
			/>
		</RootTab.Navigator>
	)
}
